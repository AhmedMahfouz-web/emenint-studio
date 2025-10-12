/**
 * Adaptive Header - Smart Color Detection System
 * Automatically switches header text color based on background brightness
 * Works with transparent/semi-transparent headers
 * 
 * Features:
 * - Performance optimized with Intersection Observer API
 * - Smart brightness detection for images, gradients, and solid colors
 * - Smooth transitions between color states
 * - Throttled scroll events for better performance
 * - Works across all modern browsers
 */

class AdaptiveHeader {
    constructor(options = {}) {
        // Configuration options
        this.config = {
            headerSelector: '#header',
            textElements: '#header #logo .cls-2, #header .main-menu a, #header .burger-inner span',
            sectionSelector: 'section, div[class*="block"], .index-page-teaser, .introtext, .latest, .brand-links, .page-teaser, .latest--big-one, .cover-image',
            threshold: 0.4, // Brightness threshold (0-1) - slightly lower for better detection
            transitionDuration: 200, // CSS transition duration in ms - faster for smoothness
            throttleDelay: 32, // ~30fps for better performance
            observerRootMargin: '0px 0px -50% 0px', // Only check top half of viewport
            videoSections: ['.index-page-teaser', '.page-teaser--video'], // Sections with video backgrounds
            ...options
        };

        // State management
        this.isInitialized = false;
        this.currentMode = 'light'; // 'light' or 'dark'
        this.throttleTimer = null;
        this.intersectionObserver = null;
        this.sections = [];
        
        // DOM elements
        this.header = null;
        this.textElements = [];
        
        // Canvas for color sampling
        this.canvas = null;
        this.ctx = null;

        this.init();
    }

    /**
     * Initialize the adaptive header system
     */
    init() {
        if (this.isInitialized) return;

        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    /**
     * Setup all components
     */
    setup() {
        try {
            this.setupDOM();
            this.setupCanvas();
            this.setupIntersectionObserver();
            this.setupEventListeners();
            this.addStyles();
            
            // Initial check
            this.checkHeaderBackground();
            
            this.isInitialized = true;
        } catch (error) {
        }
    }

    /**
     * Setup DOM elements
     */
    setupDOM() {
        this.header = document.querySelector(this.config.headerSelector);
        if (!this.header) {
            throw new Error(`Header element not found: ${this.config.headerSelector}`);
        }

        // Get all text elements that need color adaptation
        this.textElements = Array.from(document.querySelectorAll(this.config.textElements));
        
        // Get all sections for intersection observation
        this.sections = Array.from(document.querySelectorAll(this.config.sectionSelector));
        
        // Ensure videos can play properly
        this.ensureVideoPlayback();
        
    }

    /**
     * Ensure video elements can play properly
     */
    ensureVideoPlayback() {
        const videos = document.querySelectorAll('video');
        videos.forEach(video => {
            // Ensure video properties are set correctly
            video.muted = true;
            video.playsInline = true;
            video.loop = true;
            video.autoplay = true;
            
            // Add event listeners to prevent pausing
            video.addEventListener('pause', () => {
                setTimeout(() => {
                    if (video.paused) {
                        video.play().catch(() => {});
                    }
                }, 100);
            });
            
            // Force play if paused
            if (video.paused) {
                video.play().catch(error => {
                    // Try again after a short delay
                    setTimeout(() => {
                        video.play().catch(() => {});
                    }, 500);
                });
            }
        });
    }

    /**
     * Setup canvas for color sampling
     */
    setupCanvas() {
        this.canvas = document.createElement('canvas');
        this.canvas.width = 1;
        this.canvas.height = 1;
        this.ctx = this.canvas.getContext('2d', { willReadFrequently: true });
    }

    /**
     * Setup Intersection Observer for performance optimization
     */
    setupIntersectionObserver() {
        if (!window.IntersectionObserver) {
            // Fallback for older browsers
            this.setupScrollFallback();
            return;
        }

        const options = {
            root: null,
            rootMargin: this.config.observerRootMargin,
            threshold: [0, 0.1, 0.5, 1]
        };

        this.intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.throttledCheck();
                }
            });
        }, options);

        // Observe all sections
        this.sections.forEach(section => {
            this.intersectionObserver.observe(section);
        });
    }

    /**
     * Fallback for browsers without Intersection Observer
     */
    setupScrollFallback() {
        window.addEventListener('scroll', () => this.throttledCheck(), { passive: true });
        window.addEventListener('resize', () => this.throttledCheck(), { passive: true });
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Handle window resize
        window.addEventListener('resize', () => this.throttledCheck(), { passive: true });
        
        // Handle orientation change on mobile
        window.addEventListener('orientationchange', () => {
            setTimeout(() => this.throttledCheck(), 100);
        });

        // Handle dynamic content changes and lazy loading
        if (window.MutationObserver) {
            const observer = new MutationObserver((mutations) => {
                let shouldRecheck = false;
                mutations.forEach(mutation => {
                    // Check for lazy-loaded images (data-bg to background-image)
                    if (mutation.type === 'attributes' && 
                        (mutation.attributeName === 'style' || mutation.attributeName === 'class')) {
                        shouldRecheck = true;
                    }
                    // Check for new elements being added
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        shouldRecheck = true;
                    }
                });
                
                if (shouldRecheck) {
                    this.throttledCheck();
                    this.ensureVideoPlayback(); // Re-check videos on DOM changes
                }
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['style', 'class', 'data-bg']
            });
        }
    }

    /**
     * Add necessary CSS styles
     */
    addStyles() {
        const styleId = 'adaptive-header-styles';
        if (document.getElementById(styleId)) return;

        const styles = `
            /* Adaptive Header Styles */
            #header {
                transition: all ${this.config.transitionDuration}ms ease;
            }
            
            #header .adaptive-text {
                transition: color ${this.config.transitionDuration}ms ease, 
                           fill ${this.config.transitionDuration}ms ease,
                           background-color ${this.config.transitionDuration}ms ease;
            }
            
            /* Dark mode - white text */
            #header.header-dark .adaptive-text,
            #header.header-dark #logo .cls-2 {
                color: #ffffff !important;
                fill: #ffffff !important;
            }
            
            #header.header-dark .burger-inner span {
                background-color: #ffffff !important;
            }
            
            /* Light mode - dark text */
            #header.header-light .adaptive-text,
            #header.header-light #logo .cls-2 {
                color: #212121 !important;
                fill: #212121 !important;
            }
            
            #header.header-light .burger-inner span {
                background-color: #212121 !important;
            }
            
            /* CSS-only fallback using mix-blend-mode */
            @supports (mix-blend-mode: difference) {
                .adaptive-header-fallback .adaptive-text {
                    mix-blend-mode: difference;
                    color: #ffffff;
                }
                
                .adaptive-header-fallback #logo .cls-2 {
                    mix-blend-mode: difference;
                    fill: #ffffff;
                }
            }
        `;

        const styleSheet = document.createElement('style');
        styleSheet.id = styleId;
        styleSheet.textContent = styles;
        document.head.appendChild(styleSheet);

        // Add adaptive-text class to text elements
        this.textElements.forEach(element => {
            element.classList.add('adaptive-text');
        });
    }

    /**
     * Throttled background check for performance
     */
    throttledCheck() {
        if (this.throttleTimer) return;
        
        this.throttleTimer = setTimeout(() => {
            this.checkHeaderBackground();
            this.throttleTimer = null;
        }, this.config.throttleDelay);
    }

    /**
     * Main function to check header background and adjust colors
     */
    checkHeaderBackground() {
        try {
            const headerRect = this.header.getBoundingClientRect();
            const centerX = headerRect.left + headerRect.width / 2;
            const centerY = headerRect.top + headerRect.height / 2;

            // Get the average brightness of the area behind the header
            const brightness = this.getBackgroundBrightness(centerX, centerY, headerRect);
            
            // Simple and correct logic:
            // If background is bright (>threshold), use dark text (light mode)
            // If background is dark (<threshold), use light text (dark mode)
            const isDarkBackground = brightness < this.config.threshold;
            const newMode = isDarkBackground ? 'dark' : 'light';

            // Add debugging information

            if (newMode !== this.currentMode) {
                this.updateHeaderMode(newMode);
                this.currentMode = newMode;
            }
        } catch (error) {
        }
    }

    /**
     * Get the average brightness of the area behind the header (simplified for performance)
     */
    getBackgroundBrightness(centerX, centerY, headerRect) {
        // Simplified sampling for better performance
        const samplePoints = [
            { x: centerX, y: centerY }, // Center
            { x: centerX - headerRect.width * 0.25, y: centerY }, // Left
            { x: centerX + headerRect.width * 0.25, y: centerY }, // Right
            { x: centerX, y: centerY + headerRect.height * 0.2 }, // Bottom
        ];

        let totalBrightness = 0;
        let validSamples = 0;

        samplePoints.forEach(point => {
            const brightness = this.samplePointBrightness(point.x, point.y);
            if (brightness !== null) {
                totalBrightness += brightness;
                validSamples++;
            }
        });

        return validSamples > 0 ? totalBrightness / validSamples : 0.5;
    }

    /**
     * Sample brightness at a specific point
     */
    samplePointBrightness(x, y) {
        try {
            // Find the topmost visible element at this point (excluding header)
            const elements = document.elementsFromPoint(x, y);
            const targetElement = elements.find(el => 
                !this.header.contains(el) && 
                el !== this.header &&
                el.tagName !== 'HTML' &&
                el.tagName !== 'BODY'
            );

            if (!targetElement) return null;

            return this.calculateElementBrightness(targetElement, x, y);
        } catch (error) {
            return null;
        }
    }

    /**
     * Calculate brightness of an element (enhanced for home page)
     */
    calculateElementBrightness(element, x, y) {
        let detectionMethod = 'unknown';
        let brightness = 0.7;

        // Priority 1: Check for video elements (enhanced detection)
        const video = element.querySelector('video') || element.closest('.page-teaser--video')?.querySelector('video');
        if (video || element.classList.contains('page-teaser--video') || element.closest('.index-page-teaser')) {
            detectionMethod = 'video';
            brightness = 0.05; // Very dark video = needs white text
            return brightness;
        }

        // Priority 2: Home page specific sections
        if (element.classList.contains('index-page-teaser') || 
            element.closest('.index-page-teaser') ||
            element.classList.contains('page-teaser') ||
            element.closest('.page-teaser')) {
            detectionMethod = 'home-video-section';
            brightness = 0.05; // Dark video background
            return brightness;
        }

        // Check for project showcase with background images
        if (element.classList.contains('latest--big-one') || 
            element.closest('.latest--big-one') ||
            element.classList.contains('cover-image') ||
            element.closest('.cover-image')) {
            detectionMethod = 'project-showcase';
            brightness = 0.15; // Dark project images typically need white text
            return brightness;
        }

        // Priority 3: Check for specific classes that indicate dark/light content
        if (element.classList.contains('dark-bg') || 
            element.querySelector('.color-white') ||
            element.classList.contains('latest--big-one--text')) {
            detectionMethod = 'dark-class';
            brightness = 0.1; // Dark background = needs white text
            return brightness;
        }

        if (element.classList.contains('light-bg') || 
            element.classList.contains('introtext') ||
            element.classList.contains('brand-links') ||
            element.querySelector('.color-black, .text-dark')) {
            detectionMethod = 'light-class';
            brightness = 0.9; // Light background = needs dark text
            return brightness;
        }

        // Priority 3: Check background color
        const computedStyle = window.getComputedStyle(element);
        const backgroundColor = computedStyle.backgroundColor;
        
        if (backgroundColor && backgroundColor !== 'transparent' && backgroundColor !== 'rgba(0, 0, 0, 0)') {
            detectionMethod = 'bg-color';
            brightness = this.getColorBrightness(backgroundColor);
            return brightness;
        }

        // Priority 4: Check background image (including data-bg attribute)
        const backgroundImage = computedStyle.backgroundImage;
        const dataBg = element.getAttribute('data-bg') || element.querySelector('[data-bg]')?.getAttribute('data-bg');
        
        if ((backgroundImage && backgroundImage !== 'none' && !backgroundImage.includes('gradient')) || dataBg) {
            detectionMethod = 'bg-image';
            
            // Enhanced detection for project images and hero sections
            if (element.classList.contains('cover-image') || 
                element.classList.contains('parallax-section--image') ||
                element.closest('.latest--big-one') ||
                element.closest('.parallax-section')) {
                brightness = 0.15; // Project images are typically dark
                return brightness;
            }
            
            // For background images, check if there are white text elements (indicates dark image)
            const whiteTextElements = element.querySelectorAll('.color-white, [class*="white"]');
            if (whiteTextElements.length > 0) {
                brightness = 0.1; // Dark image = needs white text
            } else {
                brightness = 0.6; // Default for images
            }
            return brightness;
        }

        // Priority 5: Check parent elements
        let parent = element.parentElement;
        let depth = 0;
        while (parent && parent !== document.body && depth < 3) {
            const parentVideo = parent.querySelector('video');
            if (parentVideo) {
                detectionMethod = 'parent-video';
                brightness = 0.1; // Dark video background
                return brightness;
            }

            const parentStyle = window.getComputedStyle(parent);
            const parentBg = parentStyle.backgroundColor;
            
            if (parentBg && parentBg !== 'transparent' && parentBg !== 'rgba(0, 0, 0, 0)') {
                detectionMethod = 'parent-bg';
                brightness = this.getColorBrightness(parentBg);
                return brightness;
            }
            
            parent = parent.parentElement;
            depth++;
        }

        detectionMethod = 'default';
        brightness = 0.7; // Default to light background (needs dark text)
        return brightness;
    }

    /**
     * Calculate brightness from a color string
     */
    getColorBrightness(colorString) {
        const rgb = this.parseColor(colorString);
        if (!rgb) return 0.5;

        // Use relative luminance formula
        const { r, g, b } = rgb;
        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        return luminance;
    }

    /**
     * Parse color string to RGB values
     */
    parseColor(colorString) {
        // Create a temporary element to parse the color
        const div = document.createElement('div');
        div.style.color = colorString;
        document.body.appendChild(div);
        
        const computedColor = window.getComputedStyle(div).color;
        document.body.removeChild(div);

        const match = computedColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
        if (match) {
            return {
                r: parseInt(match[1]),
                g: parseInt(match[2]),
                b: parseInt(match[3])
            };
        }
        return null;
    }

    // Removed complex image analysis - using simplified detection

    /**
     * Get brightness from gradient
     */
    getGradientBrightness(gradient) {
        // Simple heuristic for gradients
        // In a real implementation, you might want to parse and analyze the gradient colors
        if (gradient.includes('rgba(0,0,0') || gradient.includes('rgb(0,0,0')) {
            return 0.2;
        }
        if (gradient.includes('rgba(255,255,255') || gradient.includes('rgb(255,255,255')) {
            return 0.8;
        }
        return 0.4; // Default for gradients
    }

    // Removed complex video analysis - using simplified detection

    /**
     * Update header visual mode
     */
    updateHeaderMode(mode) {
        // Remove existing mode classes
        this.header.classList.remove('header-light', 'header-dark');
        
        // Add new mode class
        this.header.classList.add(`header-${mode}`);
        
        // Dispatch custom event for other scripts to listen to
        const event = new CustomEvent('headerModeChange', {
            detail: { mode, previousMode: this.currentMode }
        });
        document.dispatchEvent(event);
        
    }

    /**
     * Enable CSS-only fallback mode
     */
    enableFallbackMode() {
        document.body.classList.add('adaptive-header-fallback');
    }

    /**
     * Destroy the adaptive header instance
     */
    destroy() {
        if (this.intersectionObserver) {
            this.intersectionObserver.disconnect();
        }
        
        if (this.throttleTimer) {
            clearTimeout(this.throttleTimer);
        }

        // Remove event listeners
        window.removeEventListener('scroll', this.throttledCheck);
        window.removeEventListener('resize', this.throttledCheck);
        window.removeEventListener('orientationchange', this.throttledCheck);

        // Remove classes
        this.header?.classList.remove('header-light', 'header-dark');
        this.textElements.forEach(el => el.classList.remove('adaptive-text'));

        this.isInitialized = false;
    }
}

// Auto-initialize when script loads
document.addEventListener('DOMContentLoaded', function() {
    // Check if we should enable the adaptive header
    if (document.querySelector('#header')) {
        window.adaptiveHeader = new AdaptiveHeader();
        
        // Enable fallback mode for older browsers
        if (!window.IntersectionObserver || !window.MutationObserver) {
            window.adaptiveHeader.enableFallbackMode();
        }
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AdaptiveHeader;
}
