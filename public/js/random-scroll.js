/**
 * Random Scroll Effect
 * Creates actual directional scrolling between positioned sections
 */
class RandomScrollEffect {
    constructor() {
        this.currentSection = 0;
        this.isAnimating = false;
        this.scrollDirections = [
            'right',     // First scroll: move right
            'down-left', // Second scroll: move down-left
            'down-right', // Third scroll: move down-right
            'left',      // Fourth scroll: move left
            'up-right',  // Fifth scroll: move up-right
            'down'       // Final scroll: move down
        ];
        this.sections = [];
        this.container = null;
        this.lastScrollY = 0;
        this.scrollThreshold = 50; // Minimum scroll distance to trigger movement
        this.sectionPositions = [];
        
        this.init();
    }

    init() {
        this.createScrollSections();
        this.setupEventListeners();
        this.setupContainer();
    }

    createScrollSections() {
        // Get all main sections from your page
        const mainSections = [
            '.index-page-teaser',
            '.introtext',
            '.brand-links', 
            '.latest',
            '.introtext:last-of-type'
        ];

        // Position sections in a grid layout
        const positions = [
            { x: 0, y: 0 },      // Center (start)
            { x: 100, y: 0 },    // Right
            { x: -50, y: 100 },  // Down-left
            { x: 50, y: 100 },   // Down-right
            { x: -100, y: 0 },   // Left
            { x: 0, y: -50 }     // Up (final)
        ];

        mainSections.forEach((selector, index) => {
            const element = document.querySelector(selector);
            if (element) {
                element.classList.add('scroll-section');
                element.setAttribute('data-section', index);
                
                // Position the section
                const position = positions[index] || { x: 0, y: index * 100 };
                element.style.position = 'absolute';
                element.style.left = `${position.x}vw`;
                element.style.top = `${position.y}vh`;
                element.style.width = '100vw';
                element.style.height = '100vh';
                
                this.sections.push({
                    element: element,
                    index: index,
                    direction: this.scrollDirections[index] || 'down',
                    position: position
                });
                
                this.sectionPositions.push(position);
            }
        });
        
        // Set initial viewport position
        this.scrollToPosition(0, 0);
    }

    setupContainer() {
        this.container = document.getElementById('page');
        if (this.container) {
            this.container.style.position = 'relative';
            this.container.style.width = '300vw'; // Wide enough for horizontal sections
            this.container.style.height = '300vh'; // Tall enough for vertical sections
            this.container.style.transition = 'transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            this.container.style.transformOrigin = 'top left';
        }
        
        // Setup body and html for proper scrolling
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
    }
    
    scrollToPosition(x, y) {
        if (this.container) {
            this.container.style.transform = `translate(${-x}vw, ${-y}vh)`;
        }
    }

    setupEventListeners() {
        // Use wheel event instead of scroll since we're controlling movement manually
        window.addEventListener('wheel', (e) => {
            e.preventDefault();
            
            if (this.isAnimating) return;
            
            // Determine scroll direction
            const deltaY = e.deltaY;
            
            if (deltaY > 0) {
                // Scrolling down - move to next section
                this.moveToNextSection();
            } else {
                // Scrolling up - move to previous section
                this.moveToPreviousSection();
            }
        }, { passive: false });
        
        // Touch support for mobile
        let touchStartY = 0;
        window.addEventListener('touchstart', (e) => {
            touchStartY = e.touches[0].clientY;
        });
        
        window.addEventListener('touchend', (e) => {
            if (this.isAnimating) return;
            
            const touchEndY = e.changedTouches[0].clientY;
            const deltaY = touchStartY - touchEndY;
            
            if (Math.abs(deltaY) > 50) { // Minimum swipe distance
                if (deltaY > 0) {
                    this.moveToNextSection();
                } else {
                    this.moveToPreviousSection();
                }
            }
        });
    }

    moveToNextSection() {
        if (this.currentSection < this.sections.length - 1) {
            this.animateToSection(this.currentSection + 1);
        }
    }
    
    moveToPreviousSection() {
        if (this.currentSection > 0) {
            this.animateToSection(this.currentSection - 1);
        }
    }

    animateToSection(sectionIndex) {
        if (this.isAnimating || sectionIndex >= this.sections.length || sectionIndex < 0) return;
        
        this.isAnimating = true;
        this.currentSection = sectionIndex;
        
        const section = this.sections[sectionIndex];
        const position = section.position;
        
        // Move to the section's actual position
        this.scrollToPosition(position.x, position.y);
        
        // Add visual feedback
        this.createTransitionOverlay(section.direction);
        
        // Reset animation flag after transition
        setTimeout(() => {
            this.isAnimating = false;
            // Dispatch section change event
            document.dispatchEvent(new CustomEvent('sectionChanged', {
                detail: { section: this.currentSection, direction: section.direction }
            }));
        }, 1200);
    }

    applyDirectionalMovement(direction, callback) {
        const transforms = {
            'right': 'translateX(100vw) scale(0.8)',
            'down-left': 'translate(-50vw, 50vh) rotate(-5deg) scale(0.9)',
            'down-right': 'translate(50vw, 50vh) rotate(5deg) scale(0.9)',
            'left': 'translateX(-100vw) scale(0.8)',
            'up-right': 'translate(50vw, -30vh) rotate(3deg) scale(0.95)',
            'down': 'translateY(30vh) scale(0.95)'
        };

        const transform = transforms[direction] || 'scale(0.95)';
        
        if (this.container) {
            // Add a subtle blur effect during transition
            this.container.style.filter = 'blur(2px)';
            this.container.style.transform = transform;
            
            // Create a visual effect overlay
            this.createTransitionOverlay(direction);
            
            setTimeout(() => {
                this.container.style.filter = 'blur(0px)';
                if (callback) callback();
            }, 600);
        }
    }

    createTransitionOverlay(direction) {
        // Remove existing overlay
        const existingOverlay = document.querySelector('.scroll-transition-overlay');
        if (existingOverlay) {
            existingOverlay.remove();
        }

        // Create new overlay with direction-based gradient
        const overlay = document.createElement('div');
        overlay.className = 'scroll-transition-overlay';
        
        const gradients = {
            'right': 'linear-gradient(90deg, transparent 0%, rgba(0,59,244,0.1) 50%, transparent 100%)',
            'down-left': 'linear-gradient(135deg, rgba(0,59,244,0.1) 0%, transparent 50%)',
            'down-right': 'linear-gradient(45deg, rgba(0,59,244,0.1) 0%, transparent 50%)',
            'left': 'linear-gradient(-90deg, transparent 0%, rgba(0,59,244,0.1) 50%, transparent 100%)',
            'up-right': 'linear-gradient(-45deg, rgba(0,59,244,0.1) 0%, transparent 50%)',
            'down': 'linear-gradient(180deg, transparent 0%, rgba(0,59,244,0.1) 50%, transparent 100%)'
        };

        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: ${gradients[direction] || gradients['down']};
            pointer-events: none;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;

        document.body.appendChild(overlay);
        
        // Animate overlay
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            setTimeout(() => {
                overlay.style.opacity = '0';
                setTimeout(() => overlay.remove(), 300);
            }, 400);
        });
    }

    resetTransform() {
        if (this.container) {
            this.container.style.transform = 'none';
            this.container.style.filter = 'none';
        }
    }

    // Method to manually trigger scroll to specific section
    scrollToSection(index) {
        if (index >= 0 && index < this.sections.length) {
            this.animateToSection(index);
        }
    }

    // Method to get current section info
    getCurrentSection() {
        return {
            index: this.currentSection,
            direction: this.sections[this.currentSection]?.direction,
            element: this.sections[this.currentSection]?.element
        };
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Add a small delay to ensure all elements are rendered
    setTimeout(() => {
        window.randomScrollEffect = new RandomScrollEffect();
        
        // Add visual indicators for sections (optional)
        if (window.location.search.includes('debug=true')) {
            window.randomScrollEffect.sections.forEach((section, index) => {
                const indicator = document.createElement('div');
                indicator.textContent = `Section ${index + 1}: ${section.direction}`;
                indicator.style.cssText = `
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: rgba(0,59,244,0.8);
                    color: white;
                    padding: 5px 10px;
                    border-radius: 5px;
                    font-size: 12px;
                    z-index: 1000;
                `;
                section.element.style.position = 'relative';
                section.element.appendChild(indicator);
            });
        }
    }, 500);
});

// Export for potential external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = RandomScrollEffect;
}
