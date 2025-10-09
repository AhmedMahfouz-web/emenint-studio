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

            // Add debugging information
            console.log(`Background brightness: ${brightness.toFixed(3)}, Mode: ${newMode}, Threshold: ${this.config.threshold}`);

            if (newMode !== this.currentMode) {
                this.updateHeaderMode(newMode);
                this.currentMode = newMode;
            }
        } catch (error) {
            console.warn('Error checking header background:', error);
        }
    }

    /**
     * Get the average brightness of the area behind the header
     */
    getBackgroundBrightness(centerX, centerY, headerRect) {
        // More comprehensive sampling points for better accuracy
        const samplePoints = [
            { x: centerX, y: centerY }, // Center
            { x: centerX - headerRect.width * 0.3, y: centerY }, // Left
            { x: centerX + headerRect.width * 0.3, y: centerY }, // Right
            { x: centerX, y: centerY + headerRect.height * 0.3 }, // Bottom
            { x: centerX - headerRect.width * 0.15, y: centerY - headerRect.height * 0.15 }, // Top-left
            { x: centerX + headerRect.width * 0.15, y: centerY - headerRect.height * 0.15 }, // Top-right
            { x: centerX - headerRect.width * 0.15, y: centerY + headerRect.height * 0.15 }, // Bottom-left
            { x: centerX + headerRect.width * 0.15, y: centerY + headerRect.height * 0.15 }, // Bottom-right
        ];

        let totalBrightness = 0;
        let validSamples = 0;
        let brightnessValues = [];

        samplePoints.forEach(point => {
            const brightness = this.samplePointBrightness(point.x, point.y);
            if (brightness !== null) {
                totalBrightness += brightness;
                brightnessValues.push(brightness);
                validSamples++;
            }
        });

        if (validSamples === 0) return 0.5;

        // Calculate average brightness
        const averageBrightness = totalBrightness / validSamples;
        
        // Add some intelligence: if there's high variance, use median instead of average
        if (brightnessValues.length > 3) {
            brightnessValues.sort((a, b) => a - b);
            const median = brightnessValues[Math.floor(brightnessValues.length / 2)];
            
            // Calculate variance
            const variance = brightnessValues.reduce((acc, val) => acc + Math.pow(val - averageBrightness, 2), 0) / brightnessValues.length;
            
            // If high variance, prefer median for stability
            if (variance > 0.1) {
                return median;
            }
        }

        return averageBrightness;
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
        // Extract image URL
        const imageUrl = backgroundImage.match(/url\(['"]?([^'"]+)['"]?\)/);
        if (!imageUrl || !imageUrl[1]) {
            return 0.4; // Default for unknown images
        }

        const imageSrc = imageUrl[1];
        
        try {
            // Create a temporary image element to analyze
            const img = new Image();
            img.crossOrigin = 'anonymous';
            
            // Return a promise-like approach using canvas sampling
            return this.analyzeImageBrightness(imageSrc);
        } catch (error) {
            console.warn('Could not analyze image brightness:', error);
            return this.getImageFallbackBrightness(imageSrc, element);
        }
    }

    /**
     * Analyze image brightness using canvas sampling
     */
    analyzeImageBrightness(imageSrc) {
        // Check if image is already loaded in the DOM
        const existingImg = document.querySelector(`img[src*="${imageSrc.split('/').pop()}"]`);
        if (existingImg && existingImg.complete) {
            return this.sampleImageBrightness(existingImg);
        }

        // Fallback to heuristic analysis
        return this.getImageFallbackBrightness(imageSrc);
    }

    /**
     * Sample brightness from an image element
     */
    sampleImageBrightness(img) {
        try {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Scale down for performance
            const maxSize = 100;
            const scale = Math.min(maxSize / img.width, maxSize / img.height);
            canvas.width = img.width * scale;
            canvas.height = img.height * scale;
            
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            
            // Sample multiple points
            const samplePoints = 9; // 3x3 grid
            let totalBrightness = 0;
            let validSamples = 0;
            
            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    const x = (canvas.width / 3) * (i + 0.5);
                    const y = (canvas.height / 3) * (j + 0.5);
                    
                    try {
                        const imageData = ctx.getImageData(x, y, 1, 1);
                        const [r, g, b] = imageData.data;
                        const brightness = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                        totalBrightness += brightness;
                        validSamples++;
                    } catch (e) {
                        // Skip invalid samples
                    }
                }
            }
            
            return validSamples > 0 ? totalBrightness / validSamples : 0.4;
        } catch (error) {
            return 0.4;
        }
    }

    /**
     * Fallback brightness detection for images
     */
    getImageFallbackBrightness(imageSrc, element = null) {
        const filename = imageSrc.toLowerCase();
        
        // Heuristic based on filename
        if (filename.includes('dark') || filename.includes('black') || filename.includes('night')) {
            return 0.2;
        }
        if (filename.includes('light') || filename.includes('white') || filename.includes('bright')) {
            return 0.8;
        }
        
        // Check element context if available
        if (element) {
            const textElements = element.querySelectorAll('.color-white, [class*="white"], .text-white');
            if (textElements.length > 0) {
                return 0.2; // If there's white text, background is probably dark
            }
            
            const darkTextElements = element.querySelectorAll('.color-black, [class*="black"], .text-black, .text-dark');
            if (darkTextElements.length > 0) {
                return 0.8; // If there's dark text, background is probably light
            }
        }
        
        return 0.4; // Neutral default for images
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
     * Get brightness from video element using canvas sampling
     */
    getVideoBrightness(video) {
        try {
            // Create a temporary canvas to sample video frame
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas size to video dimensions or default
            canvas.width = video.videoWidth || 320;
            canvas.height = video.videoHeight || 240;
            
            // Draw current video frame to canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Sample multiple points from the video frame
            const samplePoints = [
                { x: canvas.width * 0.2, y: canvas.height * 0.2 },
                { x: canvas.width * 0.5, y: canvas.height * 0.2 },
                { x: canvas.width * 0.8, y: canvas.height * 0.2 },
                { x: canvas.width * 0.2, y: canvas.height * 0.5 },
                { x: canvas.width * 0.5, y: canvas.height * 0.5 },
                { x: canvas.width * 0.8, y: canvas.height * 0.5 },
                { x: canvas.width * 0.2, y: canvas.height * 0.8 },
                { x: canvas.width * 0.5, y: canvas.height * 0.8 },
                { x: canvas.width * 0.8, y: canvas.height * 0.8 }
            ];
            
            let totalBrightness = 0;
            let validSamples = 0;
            
            samplePoints.forEach(point => {
                try {
                    const imageData = ctx.getImageData(point.x, point.y, 1, 1);
                    const [r, g, b] = imageData.data;
                    
                    // Calculate relative luminance
                    const brightness = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                    totalBrightness += brightness;
                    validSamples++;
                } catch (e) {
                    // Skip invalid samples
                }
            });
            
            if (validSamples > 0) {
                return totalBrightness / validSamples;
            }
        } catch (error) {
            console.warn('Could not sample video brightness:', error);
        }
        
        // Fallback: analyze video element styles and context
        return this.getVideoFallbackBrightness(video);
    }
    
    /**
     * Fallback brightness detection for videos
     */
    getVideoFallbackBrightness(video) {
        // Check video container background
        const container = video.closest('.page-teaser--video, .video-container, section');
        if (container) {
            const containerStyle = window.getComputedStyle(container);
            const bgColor = containerStyle.backgroundColor;
            
            if (bgColor && bgColor !== 'transparent' && bgColor !== 'rgba(0, 0, 0, 0)') {
                return this.getColorBrightness(bgColor);
            }
        }
        
        // Check for overlay elements that might indicate video brightness
        const overlay = video.parentElement.querySelector('.page-teaser--text, .overlay, [class*="overlay"]');
        if (overlay) {
            const overlayStyle = window.getComputedStyle(overlay);
            const textColor = overlayStyle.color;
            
            // If overlay text is white/light, video is probably dark
            if (textColor) {
                const brightness = this.getColorBrightness(textColor);
                // Invert the logic - if text is light, background is dark
                return brightness > 0.5 ? 0.2 : 0.8;
            }
        }
        
        // Default to neutral and let other detection methods handle it
        return 0.3; // Slightly dark assumption for videos
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
