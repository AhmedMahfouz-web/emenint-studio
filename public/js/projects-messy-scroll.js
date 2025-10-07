/**
 * Projects Messy Scroll Effect
 * Creates full-screen directional scrolling exactly like the demo
 */
class ProjectsMessyScroll {
    constructor() {
        this.isActive = false;
        this.isAnimating = false;
        this.projectsSection = null;
        this.projectElements = [];
        this.currentProjectIndex = 0;
        this.container = null;
        this.originalScrollBehavior = null;
        this.originalProjectsHTML = '';
        this.scrollAttempts = 0;
        this.lastScrollDirection = null;
        
        // Project positions like the demo - HTML order vs display position
        this.projectPositions = [
            { x: 0, y: 0, direction: 'CENTER' },        // Project 1: Center
            { x: 100, y: 0, direction: 'RIGHT' },       // Project 2: Right  
            { x: -50, y: 100, direction: 'DOWN-LEFT' }  // Project 3: Down-left
        ];
        
        this.init();
    }

    init() {
        this.findProjectsSection();
        this.setupScrollListener();
        this.createProjectGrid();
    }

    findProjectsSection() {
        this.projectsSection = document.querySelector('.latest');
        if (!this.projectsSection) {
            console.warn('Projects section (.latest) not found');
            return;
        }
        
        // Add identifier for the messy scroll zone
        this.projectsSection.classList.add('messy-scroll-zone');
        this.projectsSection.setAttribute('data-messy-scroll', 'true');
    }

    createProjectGrid() {
        if (!this.projectsSection) return;
        
        // Find all project links and remove duplicates
        const allProjectLinks = this.projectsSection.querySelectorAll('a[href]');
        const uniqueProjects = [];
        const seenHrefs = new Set();
        
        // Filter out duplicate projects
        allProjectLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (!seenHrefs.has(href)) {
                seenHrefs.add(href);
                uniqueProjects.push(link);
            }
        });
        
        // Randomly shuffle the projects
        this.shuffleArray(uniqueProjects);
        
        // Create fullscreen grid container
        this.createFullscreenGrid(uniqueProjects);
        
        console.log('✅ Fullscreen projects grid created with random order');
    }
    
    shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
    
    createFullscreenGrid(projectLinks) {
        // Hide original projects
        this.projectsSection.style.opacity = '0';
        this.projectsSection.style.pointerEvents = 'none';
        
        // Create grid container
        this.gridContainer = document.createElement('div');
        this.gridContainer.className = 'projects-fullscreen-grid';
        this.gridContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            z-index: 1000;
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: repeat(${projectLinks.length}, 100vh);
            transform: translateY(0);
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        `;
        
        // Create fullscreen projects
        projectLinks.forEach((link, index) => {
            const projectContainer = document.createElement('div');
            projectContainer.className = 'fullscreen-project-item';
            projectContainer.style.cssText = `
                width: 100vw;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 50px;
                box-sizing: border-box;
                background: ${this.getProjectBackground(index)};
            `;
            
            // Clone the project content
            const clonedLink = link.cloneNode(true);
            clonedLink.style.cssText = `
                width: 80%;
                height: 80%;
                display: block;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
                background: white;
                position: relative;
                transition: transform 0.3s ease;
            `;
            
            clonedLink.addEventListener('mouseenter', () => {
                clonedLink.style.transform = 'scale(1.05)';
            });
            
            clonedLink.addEventListener('mouseleave', () => {
                clonedLink.style.transform = 'scale(1)';
            });
            
            projectContainer.appendChild(clonedLink);
            this.gridContainer.appendChild(projectContainer);
            
            this.projectElements.push({
                element: projectContainer,
                originalElement: link,
                index: index
            });
        });
        
        document.body.appendChild(this.gridContainer);
        this.currentProjectIndex = 0;
    }
    
    getProjectBackground(index) {
        const backgrounds = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)'
        ];
        return backgrounds[index % backgrounds.length];
    }

    generateMessyPositions(index, total) {
        // Create chaotic positioning patterns
        const patterns = [
            { x: 0, y: 0, rotation: 0, scale: 1, zIndex: 100 }, // Center start
            { x: 120, y: -20, rotation: 15, scale: 0.9, zIndex: 90 }, // Right tilted
            { x: -80, y: 60, rotation: -25, scale: 0.8, zIndex: 80 }, // Left down
            { x: 60, y: 80, rotation: 45, scale: 1.1, zIndex: 85 }, // Right down big
            { x: -120, y: -40, rotation: -15, scale: 0.7, zIndex: 75 }, // Far left up
            { x: 40, y: -60, rotation: 30, scale: 0.9, zIndex: 70 }, // Right up
            { x: -40, y: 120, rotation: -45, scale: 1.2, zIndex: 95 }, // Left far down
            { x: 100, y: 40, rotation: 60, scale: 0.6, zIndex: 65 }, // Right middle small
            { x: -60, y: -80, rotation: -30, scale: 0.8, zIndex: 60 }, // Left up
            { x: 80, y: -100, rotation: 90, scale: 1.3, zIndex: 55 } // Right far up huge
        ];
        
        return patterns[index % patterns.length];
    }

    setupScrollListener() {
        window.addEventListener('scroll', () => {
            if (!this.projectsSection) return;
            
            const rect = this.projectsSection.getBoundingClientRect();
            const isInProjectsSection = rect.top <= window.innerHeight && rect.bottom >= 0;
            
            if (isInProjectsSection && !this.isActive) {
                // Activate fullscreen grid mode
                this.activateGridMode();
            } else if (!isInProjectsSection && this.isActive) {
                // Deactivate grid mode
                this.deactivateGridMode();
            }
        });
        
        // Wheel event for grid navigation
        window.addEventListener('wheel', (e) => {
            if (!this.isActive || !this.gridContainer) return;
            
            e.preventDefault();
            
            const direction = e.deltaY > 0 ? 'down' : 'up';
            
            if (direction === 'down' && this.currentProjectIndex < this.projectElements.length - 1) {
                this.scrollToProject(this.currentProjectIndex + 1);
            } else if (direction === 'up' && this.currentProjectIndex > 0) {
                this.scrollToProject(this.currentProjectIndex - 1);
            } else if (direction === 'down' && this.currentProjectIndex === this.projectElements.length - 1) {
                // At last project, exit grid mode
                this.deactivateGridMode();
                setTimeout(() => {
                    window.scrollBy(0, e.deltaY);
                }, 300);
            } else if (direction === 'up' && this.currentProjectIndex === 0) {
                // At first project, exit grid mode
                this.deactivateGridMode();
                setTimeout(() => {
                    window.scrollBy(0, e.deltaY);
                }, 300);
            }
        }, { passive: false });
        
        // Arrow key navigation
        window.addEventListener('keydown', (e) => {
            if (!this.isActive) return;
            
            if (e.key === 'ArrowDown' && this.currentProjectIndex < this.projectElements.length - 1) {
                e.preventDefault();
                this.scrollToProject(this.currentProjectIndex + 1);
            } else if (e.key === 'ArrowUp' && this.currentProjectIndex > 0) {
                e.preventDefault();
                this.scrollToProject(this.currentProjectIndex - 1);
            } else if (e.key === 'Escape') {
                this.deactivateGridMode();
            }
        });
    }
    
    activateGridMode() {
        if (this.isActive) return;
        
        this.isActive = true;
        console.log('🎯 Fullscreen grid mode activated!');
        
        // Disable body scroll
        document.body.style.overflow = 'hidden';
        
        // Show first project
        this.scrollToProject(0);
    }
    
    deactivateGridMode() {
        if (!this.isActive) return;
        
        this.isActive = false;
        console.log('✅ Grid mode deactivated');
        
        // Enable body scroll
        document.body.style.overflow = '';
        
        // Hide grid container
        if (this.gridContainer) {
            this.gridContainer.style.opacity = '0';
            setTimeout(() => {
                if (this.gridContainer && this.gridContainer.parentNode) {
                    this.gridContainer.remove();
                }
            }, 300);
        }
        
        // Show original projects
        this.projectsSection.style.opacity = '';
        this.projectsSection.style.pointerEvents = '';
        
        // Reset current project
        this.currentProjectIndex = 0;
    }
    
    scrollToProject(index) {
        if (!this.gridContainer || index < 0 || index >= this.projectElements.length) return;
        
        this.currentProjectIndex = index;
        
        // Move grid to show the selected project
        const translateY = -index * 100; // Each project is 100vh tall
        this.gridContainer.style.transform = `translateY(${translateY}vh)`;
        
        console.log(`📍 Showing project ${index + 1} of ${this.projectElements.length}`);
    }
    
    getScrollProgress(rect) {
        // Calculate scroll progress more precisely like the demo
        const sectionHeight = rect.height;
        const viewportHeight = window.innerHeight;
        const sectionTop = rect.top;
        
        if (sectionTop > viewportHeight) {
            // Section hasn't entered viewport yet
            return -1;
        } else if (sectionTop + sectionHeight < 0) {
            // Section has completely passed through viewport
            return 2;
        } else {
            // Section is in viewport - calculate progress based on center of viewport
            const sectionCenter = sectionTop + (sectionHeight / 2);
            const viewportCenter = viewportHeight / 2;
            const distanceFromCenter = Math.abs(sectionCenter - viewportCenter);
            const maxDistance = (sectionHeight + viewportHeight) / 2;
            
            // Convert to 0-1 progress, where 0.5 is when section is centered
            const progress = Math.max(0, Math.min(1, 1 - (distanceFromCenter / maxDistance)));
            return progress;
        }
    }
    
    updateProjectFromScroll(progress) {
        if (this.projectElements.length === 0) return;
        
        // Map scroll progress to project index with better distribution
        let projectIndex;
        if (progress < 0.33) {
            projectIndex = 0; // First project (Artal)
        } else if (progress < 0.66) {
            projectIndex = 1; // Second project (Oracal)
        } else {
            projectIndex = 2; // Third project (Loja)
        }
        
        // Ensure we don't go out of bounds
        projectIndex = Math.min(projectIndex, this.projectElements.length - 1);
        
        if (projectIndex !== this.currentProjectIndex) {
            this.scrollToProject(projectIndex);
        }
    }

    activateNaturalMode() {
        if (this.isActive) return;
        
        this.isActive = true;
        console.log('🌪️ Natural projects mode activated!');
        
        // Hide original projects smoothly
        this.projectsSection.style.opacity = '0';
        this.projectsSection.style.transition = 'opacity 0.3s ease';
        this.projectsSection.style.pointerEvents = 'none';
        
        // Create fullscreen container
        this.createNaturalContainer();
        
        // DON'T disable body scroll - keep it natural!
    }
    
    deactivateNaturalMode() {
        if (!this.isActive) return;
        
        this.isActive = false;
        console.log('✅ Natural scroll continues');
        
        // Show original projects smoothly
        this.projectsSection.style.opacity = '';
        this.projectsSection.style.transition = '';
        this.projectsSection.style.pointerEvents = '';
        
        // Remove fullscreen container
        const fullscreenContainer = document.querySelector('.fullscreen-projects-container');
        if (fullscreenContainer) {
            fullscreenContainer.style.opacity = '0';
            fullscreenContainer.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                if (fullscreenContainer.parentNode) {
                    fullscreenContainer.remove();
                }
            }, 300);
        }
        
        // Reset current project index
        this.currentProjectIndex = 0;
    }
    
    createNaturalContainer() {
        // Remove existing container
        const existingContainer = document.querySelector('.fullscreen-projects-container');
        if (existingContainer) {
            existingContainer.remove();
        }
        
        // Create new natural container
        this.container = document.createElement('div');
        this.container.className = 'fullscreen-projects-container';
        this.container.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 300vw;
            height: 300vh;
            z-index: 1000;
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-origin: top left;
            opacity: 1;
        `;
        
        // Add all project elements to container
        this.projectElements.forEach(project => {
            this.container.appendChild(project.element);
        });
        
        document.body.appendChild(this.container);
        
        // Start at first project (center)
        this.scrollToPosition(0, 0);
    }
    
    scrollToPosition(x, y) {
        if (this.container) {
            this.container.style.transform = `translate(${-x}vw, ${-y}vh)`;
        }
    }
    
    createExitInstructions() {
        // Remove existing instructions
        const existingInstructions = document.querySelector('.fullscreen-exit-instructions');
        if (existingInstructions) {
            existingInstructions.remove();
        }
        
        // Create exit instructions
        const instructions = document.createElement('div');
        instructions.className = 'fullscreen-exit-instructions';
        instructions.innerHTML = `
            <div class="exit-hint">
                <p>Scroll up at first project or down at last project to exit</p>
                <p>Press <kbd>ESC</kbd> to exit anytime</p>
            </div>
        `;
        instructions.style.cssText = `
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 15px 25px;
            border-radius: 25px;
            font-size: 14px;
            text-align: center;
            z-index: 10001;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
            animation: fadeInOut 4s ease-in-out;
        `;
        
        document.body.appendChild(instructions);
        
        // Remove after animation
        setTimeout(() => {
            if (instructions.parentNode) {
                instructions.remove();
            }
        }, 4000);
    }

    hideOriginalProjects() {
        const originalProjects = this.projectsSection.querySelectorAll('a[href*="project"]');
        originalProjects.forEach(project => {
            if (!project.closest('.messy-project-container')) {
                project.style.opacity = '0';
                project.style.pointerEvents = 'none';
            }
        });
    }

    showOriginalProjects() {
        const originalProjects = this.projectsSection.querySelectorAll('a[href*="project"]');
        originalProjects.forEach(project => {
            if (!project.closest('.messy-project-container')) {
                project.style.opacity = '';
                project.style.pointerEvents = '';
            }
        });
    }

    showMessyProjects() {
        // Create messy container if it doesn't exist
        if (!document.querySelector('.messy-projects-container')) {
            const messyContainer = document.createElement('div');
            messyContainer.className = 'messy-projects-container';
            messyContainer.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                width: 300vw;
                height: 300vh;
                pointer-events: none;
                z-index: 1000;
            `;
            
            this.projectElements.forEach(project => {
                project.element.style.pointerEvents = 'auto';
                messyContainer.appendChild(project.element);
            });
            
            this.projectsSection.appendChild(messyContainer);
        }
    }

    hideMessyProjects() {
        const messyContainer = document.querySelector('.messy-projects-container');
        if (messyContainer) {
            messyContainer.remove();
        }
    }

    handleMessyScroll(direction) {
        // Don't trigger too frequently
        if (this.isAnimating) return;
        
        this.triggerMessyTransition(direction);
    }

    scrollToProject(index) {
        if (index < 0 || index >= this.projectElements.length) return;
        
        this.currentProjectIndex = index;
        
        const project = this.projectElements[index];
        if (project && this.container) {
            // Move to project position smoothly
            this.container.style.transform = `translate(${-project.position.x}vw, ${-project.position.y}vh)`;
        }
    }

    applyMessyEffect(project, direction) {
        const element = project.element;
        
        // Store current styles
        const currentTransform = element.style.transform || '';
        const currentTransition = element.style.transition || '';
        
        // Apply messy transform
        element.style.transition = 'all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
        element.style.transform = currentTransform + ' ' + this.getMessyTransform(direction);
        
        // Add glitch effect
        element.classList.add('glitch');
        
        // Reset after animation
        setTimeout(() => {
            element.style.transform = currentTransform;
            element.style.transition = currentTransition;
            element.classList.remove('glitch');
        }, 600);
    }
    
    getMessyTransform(direction) {
        const transforms = {
            'spiral-right': 'rotate(360deg) scale(1.2) translateX(20px)',
            'zigzag-left': 'translateX(-30px) translateY(15px) rotate(-15deg) scale(0.9)',
            'bounce-up': 'translateY(-40px) scale(1.1) rotate(10deg)',
            'slide-diagonal': 'translate(25px, 25px) rotate(8deg) scale(1.05)',
            'spin-down': 'translateY(20px) rotate(-180deg) scale(0.95)',
            'wave-right': 'translateX(35px) translateY(-10px) rotate(12deg) scale(1.08)',
            'chaos-left': 'translate(-25px, -15px) rotate(-25deg) scale(0.85)',
            'tornado': 'rotate(270deg) scale(1.15) translate(15px, -15px)',
            'shake-up': 'translateY(-25px) scale(1.03) rotate(-8deg)',
            'drift-right': 'translateX(40px) translateY(10px) rotate(6deg) scale(0.98)'
        };
        
        return transforms[direction] || 'scale(1.1) rotate(5deg)';
    }
    
    resetProjectStyles() {
        this.projectElements.forEach(project => {
            const element = project.element;
            element.style.transform = project.originalTransform;
            element.style.transition = project.originalTransition;
            element.classList.remove('glitch');
        });
    }

    getMessyExitTransform(direction) {
        const exits = {
            'spiral-right': 'rotate(720deg) scale(0.1) translateX(200vw)',
            'zigzag-left': 'translateX(-150vw) translateY(50vh) rotate(-180deg) scale(0.3)',
            'bounce-up': 'translateY(-200vh) scale(2) rotate(360deg)',
            'slide-diagonal': 'translate(100vw, 100vh) rotate(45deg) scale(0.5)',
            'spin-down': 'translateY(150vh) rotate(-540deg) scale(0.2)',
            'wave-right': 'translateX(180vw) translateY(-30vh) rotate(270deg) scale(0.8)',
            'chaos-left': 'translate(-120vw, -80vh) rotate(-720deg) scale(0.1)',
            'tornado': 'rotate(1080deg) scale(0.05) translate(50vw, -100vh)',
            'shake-up': 'translateY(-180vh) scale(1.5) rotate(180deg)',
            'drift-right': 'translateX(200vw) translateY(20vh) rotate(90deg) scale(0.6)'
        };
        
        return exits[direction] || 'scale(0) rotate(360deg)';
    }

    getMessyEntranceTransform(direction) {
        const entrances = {
            'spiral-right': 'rotate(0deg) scale(1) translateX(0)',
            'zigzag-left': 'translateX(0) translateY(0) rotate(0deg) scale(1)',
            'bounce-up': 'translateY(0) scale(1) rotate(0deg)',
            'slide-diagonal': 'translate(0, 0) rotate(0deg) scale(1)',
            'spin-down': 'translateY(0) rotate(0deg) scale(1)',
            'wave-right': 'translateX(0) translateY(0) rotate(0deg) scale(1)',
            'chaos-left': 'translate(0, 0) rotate(0deg) scale(1)',
            'tornado': 'rotate(0deg) scale(1) translate(0, 0)',
            'shake-up': 'translateY(0) scale(1) rotate(0deg)',
            'drift-right': 'translateX(0) translateY(0) rotate(0deg) scale(1)'
        };
        
        return entrances[direction] || 'scale(1) rotate(0deg)';
    }

    applyScreenShake() {
        const body = document.body;
        body.style.animation = 'messyShake 0.5s ease-in-out';
        
        setTimeout(() => {
            body.style.animation = '';
        }, 500);
    }

    createChaosOverlay(direction) {
        // Remove existing overlay
        const existingOverlay = document.querySelector('.chaos-overlay');
        if (existingOverlay) existingOverlay.remove();
        
        // Create new chaos overlay
        const overlay = document.createElement('div');
        overlay.className = 'chaos-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(circle, rgba(0,59,244,0.3) 0%, transparent 70%);
            pointer-events: none;
            z-index: 9999;
            opacity: 0;
            animation: chaosFlash 1s ease-out;
        `;
        
        document.body.appendChild(overlay);
        
        setTimeout(() => overlay.remove(), 1000);
    }

    // Method to manually navigate to specific project
    goToProject(index) {
        if (index >= 0 && index < this.projectElements.length && this.isActive) {
            this.animateToProject(index);
        }
    }

    // Get current project info
    getCurrentProject() {
        return {
            index: this.currentProjectIndex,
            total: this.projectElements.length,
            direction: this.projectElements[this.currentProjectIndex]?.direction,
            isActive: this.isActive
        };
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        window.projectsMessyScroll = new ProjectsMessyScroll();
        
        // Add debug info if needed
        if (window.location.search.includes('debug=true')) {
            setInterval(() => {
                if (window.projectsMessyScroll) {
                    const info = window.projectsMessyScroll.getCurrentProject();
                    console.log('Projects Messy Scroll:', info);
                }
            }, 2000);
        }
    }, 1000);
});

// Export for external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProjectsMessyScroll;
}
