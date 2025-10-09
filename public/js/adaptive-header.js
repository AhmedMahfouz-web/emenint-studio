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
            sectionSelector: 'section, div[class*="block"], .index-page-teaser, .introtext',
            threshold: 0.5, // Brightness threshold (0-1)
            transitionDuration: 300, // CSS transition duration in ms
            throttleDelay: 16, // ~60fps for scroll events
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
            console.log('Adaptive Header initialized successfully');
        } catch (error) {
            console.error('Failed to initialize Adaptive Header:', error);
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
        
        console.log(`Found ${this.textElements.length} text elements and ${this.sections.length} sections`);
    }

    /**
     * Ensure video elements can play properly
     */
    ensureVideoPlayback() {
        const videos = document.querySelectorAll('video[autoplay]');
        videos.forEach(video => {
            // Ensure video properties are set correctly
            video.muted = true;
            video.playsInline = true;
            video.loop = true;
            
            // Force play if paused
            if (video.paused) {
                video.play().catch(error => {
                    console.warn('Video autoplay failed:', error);
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
        console.warn('Intersection Observer not supported, using scroll fallback');
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

        // Handle dynamic content changes
        if (window.MutationObserver) {
            const observer = new MutationObserver(() => {
                this.throttledCheck();
                this.ensureVideoPlayback(); // Re-check videos on DOM changes
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['style', 'class']
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
            
            // Determine if we need light or dark text
            const shouldUseDarkText = brightness > this.config.threshold;
            const newMode = shouldUseDarkText ? 'light' : 'dark';

            if (newMode !== this.currentMode) {
                this.updateHeaderMode(newMode);
                this.currentMode = newMode;
            }
        } catch (error) {
            console.warn('Error checking header background:', error);
        }
    }

    /**
     * Calculate background brightness behind the header
     */
    getBackgroundBrightness(x, y, headerRect) {
        const samplePoints = [
            { x: x, y: y }, // Center
            { x: x - headerRect.width * 0.25, y: y }, // Left
            { x: x + headerRect.width * 0.25, y: y }, // Right
            { x: x, y: y + headerRect.height * 0.25 }, // Bottom
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
     * Calculate brightness of an element
     */
    calculateElementBrightness(element, x, y) {
        // Check if element contains a video first
        const video = element.querySelector('video');
        if (video) {
            return this.getVideoBrightness(video);
        }

        const computedStyle = window.getComputedStyle(element);
        
        // Check background image
        const backgroundImage = computedStyle.backgroundImage;
        if (backgroundImage && backgroundImage !== 'none') {
            return this.getImageBrightness(element, backgroundImage);
        }

        // Check background color
        const backgroundColor = computedStyle.backgroundColor;
        if (backgroundColor && backgroundColor !== 'transparent' && backgroundColor !== 'rgba(0, 0, 0, 0)') {
            return this.getColorBrightness(backgroundColor);
        }

        // Check for gradient
        if (backgroundImage.includes('gradient')) {
            return this.getGradientBrightness(backgroundImage);
        }

        // Fallback: check parent elements
        let parent = element.parentElement;
        while (parent && parent !== document.body) {
            const parentVideo = parent.querySelector('video');
            if (parentVideo) {
                return this.getVideoBrightness(parentVideo);
            }

            const parentStyle = window.getComputedStyle(parent);
            const parentBg = parentStyle.backgroundColor;
            
            if (parentBg && parentBg !== 'transparent' && parentBg !== 'rgba(0, 0, 0, 0)') {
                return this.getColorBrightness(parentBg);
            }
            parent = parent.parentElement;
        }

        return 0.5; // Default neutral brightness
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

    /**
     * Get brightness from background image
     */
    getImageBrightness(element, backgroundImage) {
        // For images, we'll use a heuristic based on the image URL or return neutral
        // In a real implementation, you might want to load and analyze the image
        
        // Check if it's a dark/light image based on filename
        const imageUrl = backgroundImage.match(/url\(['"]?([^'"]+)['"]?\)/);
        if (imageUrl && imageUrl[1]) {
            const filename = imageUrl[1].toLowerCase();
            if (filename.includes('dark') || filename.includes('black')) {
                return 0.2;
            }
            if (filename.includes('light') || filename.includes('white')) {
                return 0.8;
            }
        }

        return 0.3; // Assume images are generally darker
    }

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

    /**
     * Get brightness from video element
     */
    getVideoBrightness(video) {
        // For video backgrounds, we'll use heuristics based on the video source
        // and assume most promotional videos are darker
        
        const videoSrc = video.src || (video.querySelector('source') && video.querySelector('source').src);
        
        if (videoSrc) {
            const filename = videoSrc.toLowerCase();
            
            // Check for specific video types that are typically dark
            if (filename.includes('promo') || 
                filename.includes('hero') || 
                filename.includes('intro') ||
                filename.includes('eminent')) {
                return 0.2; // Dark video, needs light text
            }
            
            // Check for light video indicators
            if (filename.includes('light') || filename.includes('bright')) {
                return 0.8; // Light video, needs dark text
            }
        }
        
        // Default assumption: most hero/background videos are dark
        return 0.2; // Assume dark video background
    }

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
        
        console.log(`Header mode changed to: ${mode}`);
    }

    /**
     * Enable CSS-only fallback mode
     */
    enableFallbackMode() {
        document.body.classList.add('adaptive-header-fallback');
        console.log('Adaptive Header fallback mode enabled');
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
        console.log('Adaptive Header destroyed');
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
