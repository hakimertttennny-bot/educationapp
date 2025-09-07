<template>
  <div id="app">
    <!-- Header -->
    <header class="header" data-header>
      <div class="container">
        <a href="/" class="logo">
          <img src="/assets/images/logo.svg" width="162" height="50" alt="EduWeb logo">
        </a>
        
        <nav class="navbar" data-navbar>
          <div class="navbar-top">
            <button class="nav-close-btn" aria-label="Close menu" @click="closeNavbar">
              <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
            </button>
          </div>
          <ul class="navbar-list">
            <li v-for="item in navigationItems" :key="item.id" class="navbar-item">
              <router-link :to="item.href" class="navbar-link" @click="closeNavbar">{{ item.text }}</router-link>
            </li>
          </ul>
          <!-- Mobile Auth Buttons -->
         
        </nav>
        
        <div class="header-actions">
          <button class="header-action-btn" aria-label="Toggle search" title="Search" @click="toggleSearch">
            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
          </button>
          
          <!-- User Profile Button (when logged in) -->
          <div v-if="isAuthenticated" class="user-menu">
            <button class="header-action-btn" aria-label="user profile" title="Profile" @click="toggleUserMenu">
              <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
            </button>
            <div class="user-dropdown" :class="{ active: isUserMenuOpen }">
              <div class="user-info">
                <p class="user-name">{{ user.name }}</p>
                <p class="user-email">{{ user.email }}</p>
              </div>
              <div class="user-actions">
                <router-link to="/dashboard" class="dropdown-link" @click="closeUserMenu">
                  <ion-icon name="grid-outline" aria-hidden="true"></ion-icon>
                  Dashboard
                </router-link>
                <router-link to="/profile" class="dropdown-link" @click="closeUserMenu">
                  <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
                  Profile
                </router-link>
                <button class="dropdown-link logout-btn" @click="handleLogout">
                  <ion-icon name="log-out-outline" aria-hidden="true"></ion-icon>
                  Logout
                </button>
              </div>
            </div>
          </div>
          
          <!-- Auth Buttons (when not logged in) -->
          <div v-else class="auth-buttons">
            <router-link to="/login" class="btn btn-outline">Login</router-link>
            <router-link to="/signup" class="btn btn-primary">Sign Up</router-link>
          </div>
          
          <button class="header-action-btn nav-toggle" aria-label="Open menu" title="Open menu" @click="openNavbar">
            <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>
        
        <div class="search-container" :class="{ active: isSearchActive }">
          <input type="search" name="search" placeholder="Search for courses..." class="search-field">
          <button class="search-submit" aria-label="Submit search" @click="toggleSearch">
            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="main-content">
      <router-view></router-view>
    </main>

    <!-- Footer -->
    <footer class="footer" style="background-image: url('/assets/images/footer-bg.png')">
      <div class="footer-top section">
        <div class="container">
          <div class="footer-brand">
            <a href="/" class="logo">
              <img src="/assets/images/logo-light.svg" width="162" height="50" alt="EduWeb logo">
            </a>
            <p class="footer-text">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            <ul class="social-list">
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-facebook"></ion-icon>
                </a>
              </li>
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-twitter"></ion-icon>
                </a>
              </li>
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-linkedin"></ion-icon>
                </a>
              </li>
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-instagram"></ion-icon>
                </a>
              </li>
            </ul>
          </div>
          <ul class="footer-list">
            <li>
              <p class="footer-list-title">Company</p>
            </li>
            <li>
              <router-link to="/about" class="footer-link">About Us</router-link>
            </li>
            <li>
              <router-link to="/courses" class="footer-link">Courses</router-link>
            </li>
            <li>
              <router-link to="/blog" class="footer-link">Blog</router-link>
            </li>
            <li>
              <router-link to="/contact" class="footer-link">Contact</router-link>
            </li>
          </ul>
          <ul class="footer-list">
            <li>
              <p class="footer-list-title">Support</p>
            </li>
            <li>
              <a href="#" class="footer-link">Help Center</a>
            </li>
            <li>
              <a href="#" class="footer-link">Terms of Service</a>
            </li>
            <li>
              <a href="#" class="footer-link">Privacy Policy</a>
            </li>
            <li>
              <a href="#" class="footer-link">Cookie Policy</a>
            </li>
          </ul>
          <ul class="footer-list">
            <li>
              <p class="footer-list-title">Newsletter</p>
            </li>
            <li>
              <p class="footer-text">
                Subscribe to our newsletter for the latest updates and exclusive offers.
              </p>
            </li>
            <li>
              <form class="newsletter-form">
                <input type="email" name="email" placeholder="Enter your email" class="newsletter-field">
                <button type="submit" class="newsletter-submit" aria-label="Submit newsletter">
                  <ion-icon name="paper-plane" aria-hidden="true"></ion-icon>
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <p class="copyright">
            &copy; {{ currentYear }} <a href="/">EduWeb</a>. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      currentYear: new Date().getFullYear(),
      navigationItems: [
        { id: 1, text: 'Home', href: '/' },
        { id: 2, text: 'About', href: '/about' },
        { id: 3, text: 'Courses', href: '/courses' },
        { id: 4, text: 'Blog', href: '/blog' },
        { id: 5, text: 'Contact', href: '/contact' }
      ],
      isSearchActive: false,
      isAuthenticated: false,
      user: null,
      isUserMenuOpen: false
    }
  },
  methods: {
    openNavbar() {
      document.querySelector('[data-navbar]').classList.add('active');
      document.querySelector('[data-overlay]').classList.add('active');
    },
    closeNavbar() {
      document.querySelector('[data-navbar]').classList.remove('active');
      document.querySelector('[data-overlay]').classList.remove('active');
    },
    toggleSearch() {
      this.isSearchActive = !this.isSearchActive;
    },
    toggleUserMenu() {
      this.isUserMenuOpen = !this.isUserMenuOpen;
    },
    closeUserMenu() {
      this.isUserMenuOpen = false;
    },
    checkAuthStatus() {
      const userData = localStorage.getItem('user');
      if (userData) {
        this.user = JSON.parse(userData);
        this.isAuthenticated = true;
      } else {
        this.user = null;
        this.isAuthenticated = false;
      }
    },
    async handleLogout() {
      try {
        const response = await fetch('/api/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include'
        });

        if (response.ok) {
          // Clear local storage
          localStorage.removeItem('user');
          this.user = null;
          this.isAuthenticated = false;
          this.isUserMenuOpen = false;
          
          // Redirect to home page
          this.$router.push('/');
          alert('Logged out successfully!');
        } else {
          // Even if API call fails, clear local storage
          localStorage.removeItem('user');
          this.user = null;
          this.isAuthenticated = false;
          this.isUserMenuOpen = false;
          this.$router.push('/');
          alert('Logged out successfully!');
        }
      } catch (error) {
        console.error('Logout error:', error);
        // Even if API call fails, clear local storage
        localStorage.removeItem('user');
        this.user = null;
        this.isAuthenticated = false;
        this.isUserMenuOpen = false;
        this.$router.push('/');
        alert('Logged out successfully!');
      }
    }
  },
  mounted() {
    // Check authentication status on app load
    this.checkAuthStatus();
    
    // Add overlay for mobile menu
    const overlay = document.createElement('div');
    overlay.setAttribute('data-overlay', '');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);
    
    // Close navbar when clicking overlay
    overlay.addEventListener('click', this.closeNavbar);
    
    // Close navbar when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('[data-navbar]') && !e.target.closest('[data-header]')) {
        this.closeNavbar();
      }
    });
    
    // Close user menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.user-menu')) {
        this.closeUserMenu();
      }
    });
    
    // Listen for storage changes (when user logs in/out in another tab)
    window.addEventListener('storage', (e) => {
      if (e.key === 'user') {
        this.checkAuthStatus();
      }
    });
  },
  watch: {
    // Watch for route changes to update auth status
    '$route'() {
      this.checkAuthStatus();
    }
  }
}
</script>

<style scoped>
/* Main Content */
.main-content {
  padding-top: 80px; /* Account for fixed header */
  min-height: calc(100vh - 80px);
}

/* Header Styles */
.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  z-index: 1000;
  padding: 15px 0;
}

.header .container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
}

.logo {
  display: flex;
  align-items: center;
  text-decoration: none;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--kappel);
  flex-shrink: 0;
}

.logo img {
  height: 40px;
  width: auto;
}

/* Navigation */
.navbar {
  display: flex;
  align-items: center;
}

.navbar-list {
  display: flex;
  align-items: center;
  gap: 30px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.navbar-link {
  color: var(--eerie-black-1);
  text-decoration: none;
  font-weight: 500;
  font-size: 1rem;
  transition: color 0.3s ease;
  position: relative;
}

.navbar-link:hover,
.navbar-link.router-link-active {
  color: var(--kappel);
}

.navbar-link::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--kappel);
  transition: width 0.3s ease;
}

.navbar-link:hover::after,
.navbar-link.router-link-active::after {
  width: 100%;
}

/* Mobile Auth Buttons */
.mobile-auth-buttons {
  display: none;
  flex-direction: column;
  gap: 15px;
  padding: 20px;
  border-top: 1px solid var(--light-gray);
  margin-top: 20px;
}

.mobile-btn {
  width: 100%;
  justify-content: center;
  padding: 15px 20px;
  font-size: 1rem;
  font-weight: 600;
}

/* Header Actions */
.header-actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

.header-action-btn {
  width: 40px;
  height: 40px;
  border: none;
  background: transparent;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--eerie-black-1);
  cursor: pointer;
  transition: all 0.3s ease;
}

.header-action-btn:hover {
  background: var(--isabelline);
  color: var(--kappel);
}

.auth-buttons {
  display: flex !important; /* Force display */
  align-items: center;
  gap: 10px;
  visibility: visible !important;
  opacity: 1 !important;
}

/* Button Styles */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  cursor: pointer;
  white-space: nowrap;
}

/* Ensure auth buttons are always visible */
.header .auth-buttons {
  display: flex !important;
  visibility: visible !important;
  opacity: 1 !important;
  position: relative !important;
  z-index: 1002 !important;
}

.btn-primary {
  background: var(--kappel);
  color: white;
  border-color: var(--kappel);
}

.btn-primary:hover {
  background: var(--selective-yellow);
  border-color: var(--selective-yellow);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-outline {
  background: transparent;
  color: var(--kappel);
  border-color: var(--kappel);
}

.btn-outline:hover {
  background: var(--kappel);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Search Container */
.search-container {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: white;
  padding: 20px;
  border-bottom: 1px solid var(--border-color);
  transform: translateY(-100%);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.search-container.active {
  transform: translateY(0);
  opacity: 1;
  visibility: visible;
}

.search-field {
  width: 100%;
  padding: 15px 20px;
  border: 2px solid var(--border-color);
  border-radius: 8px;
  font-size: 1rem;
  outline: none;
  transition: border-color 0.3s ease;
}

.search-field:focus {
  border-color: var(--kappel);
}

.search-submit {
  position: absolute;
  right: 35px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: var(--eerie-black-1);
  cursor: pointer;
  padding: 10px;
}

/* Mobile Navigation */
.navbar-top {
  display: none;
}

.nav-toggle {
  display: none;
}

/* Responsive Design */
@media (max-width: 768px) {
  .navbar {
    position: fixed;
    top: 0;
    right: -100%;
    width: 300px;
    height: 100vh;
    background: white;
    box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    transition: right 0.3s ease;
    z-index: 1001;
    flex-direction: column;
    align-items: stretch;
    justify-content: flex-start;
  }

  .navbar.active {
    right: 0;
  }

  .navbar-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid var(--light-gray);
  }

  .nav-close-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: transparent;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--eerie-black-1);
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .nav-close-btn:hover {
    background: var(--isabelline);
    color: var(--kappel);
  }

  .navbar-list {
    flex-direction: column;
    gap: 0;
    padding: 20px 0;
    flex: 1;
  }

  .navbar-item {
    width: 100%;
  }

  .navbar-link {
    display: block;
    padding: 15px 20px;
    border-bottom: 1px solid var(--light-gray);
  }

  .navbar-link::after {
    display: none;
  }

  .nav-toggle {
    display: flex;
  }

  .mobile-auth-buttons {
    display: flex;
    margin-top: auto;
    padding: 20px;
    border-top: 1px solid var(--light-gray);
  }

  .header-actions {
    gap: 8px;
  }

  .auth-buttons {
    gap: 5px;
    display: flex !important; /* Ensure auth buttons are visible */
    visibility: visible !important;
    opacity: 1 !important;
  }

  .btn {
    padding: 8px 16px;
    font-size: 0.85rem;
  }
}

@media (max-width: 480px) {
  .header .container {
    gap: 10px;
  }

  .logo img {
    height: 35px;
  }

  .header-actions {
    gap: 5px;
  }

  .auth-buttons {
    gap: 3px;
    display: flex !important; /* Ensure auth buttons are visible */
    visibility: visible !important;
    opacity: 1 !important;
  }

  .btn {
    padding: 6px 12px;
    font-size: 0.8rem;
  }

  .header-action-btn {
    width: 35px;
    height: 35px;
  }

  .mobile-btn {
    padding: 12px 16px;
    font-size: 0.9rem;
  }
  
  /* Ensure auth buttons are visible and properly sized on mobile */
  .auth-buttons .btn {
    min-width: 60px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .auth-buttons .btn .span {
    font-size: 0.75rem;
  }
}

/* Extra small screens */
@media (max-width: 360px) {
  .header .container {
    gap: 5px;
  }
  
  .auth-buttons {
    gap: 2px;
    display: flex !important;
    visibility: visible !important;
    opacity: 1 !important;
  }
  
  .auth-buttons .btn {
    padding: 4px 8px;
    font-size: 0.7rem;
    min-width: 50px;
  }
  
  .auth-buttons .btn .span {
    font-size: 0.7rem;
  }
  
  .header-action-btn {
    width: 30px;
    height: 30px;
  }
}

/* User Menu Styles */
.user-menu {
  position: relative;
}

.user-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  background: white;
  border-radius: 8px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  min-width: 200px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.3s ease;
  z-index: 1000;
  margin-top: 10px;
}

.user-dropdown.active {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.user-info {
  padding: 15px 20px;
  border-bottom: 1px solid #E5E7EB;
}

.user-name {
  font-weight: 600;
  color: var(--eerie-black-1);
  margin: 0 0 5px 0;
  font-size: 0.9rem;
}

.user-email {
  color: var(--gray-web);
  margin: 0;
  font-size: 0.8rem;
}

.user-actions {
  padding: 10px 0;
}

.dropdown-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  color: var(--eerie-black-1);
  text-decoration: none;
  font-size: 0.9rem;
  transition: background-color 0.3s ease;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
}

.dropdown-link:hover {
  background: #F3F4F6;
}

.dropdown-link.logout-btn {
  color: #DC2626;
}

.dropdown-link.logout-btn:hover {
  background: #FEE2E2;
}

.dropdown-link ion-icon {
  font-size: 1.1rem;
}

/* Auth Buttons */
.auth-buttons {
  display: flex;
  gap: 10px;
  align-items: center;
}

.auth-buttons .btn {
  padding: 8px 16px;
  font-size: 0.9rem;
  text-decoration: none;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.auth-buttons .btn-outline {
  color: var(--kappel);
  border: 2px solid var(--kappel);
  background: transparent;
}

.auth-buttons .btn-outline:hover {
  background: var(--kappel);
  color: white;
}

.auth-buttons .btn-primary {
  background: var(--kappel);
  color: white;
  border: 2px solid var(--kappel);
}

.auth-buttons .btn-primary:hover {
  background: #0F766E;
  border-color: #0F766E;
}

/* Overlay */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.overlay.active {
  opacity: 1;
  visibility: visible;
}

/* Footer Styles */
.footer {
  background: var(--eerie-black-2);
  color: white;
  margin-top: auto;
}

.footer-top {
  padding: 80px 0 40px;
}

.footer-brand .logo {
  margin-bottom: 20px;
}

.footer-text {
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.6;
  margin-bottom: 30px;
}

.social-list {
  display: flex;
  gap: 15px;
  list-style: none;
  padding: 0;
  margin: 0;
}

.social-link {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-decoration: none;
  transition: all 0.3s ease;
}

.social-link:hover {
  background: var(--kappel);
  transform: translateY(-3px);
}

.footer-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-list-title {
  font-weight: 600;
  margin-bottom: 20px;
  color: white;
}

.footer-link {
  display: block;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  padding: 8px 0;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: var(--kappel);
}

.newsletter-form {
  display: flex;
  gap: 10px;
  margin-top: 15px;
}

.newsletter-field {
  flex: 1;
  padding: 12px 15px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  outline: none;
}

.newsletter-field::placeholder {
  color: rgba(255, 255, 255, 0.6);
}

.newsletter-submit {
  width: 45px;
  height: 45px;
  background: var(--kappel);
  border: none;
  border-radius: 8px;
  color: white;
  cursor: pointer;
  transition: background 0.3s ease;
}

.newsletter-submit:hover {
  background: var(--selective-yellow);
}

.footer-bottom {
  padding: 20px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  text-align: center;
}

.copyright {
  color: rgba(255, 255, 255, 0.6);
  margin: 0;
}

.copyright a {
  color: var(--kappel);
  text-decoration: none;
}

/* Responsive Footer */
@media (max-width: 768px) {
  .footer-top .container {
    grid-template-columns: 1fr;
    gap: 40px;
  }
  
  .newsletter-form {
    flex-direction: column;
  }
}
</style>
