<template>
  <main>
    <!-- Signup Hero Section -->
    <section class="hero signup-hero" aria-label="signup hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="h1 hero-title">
            Join <span class="span">EduWeb</span>
          </h1>
          <p class="hero-text">
            Create your account and start your learning journey today. Access thousands of courses and enhance your skills.
          </p>
        </div>
        <figure class="hero-banner">
          <img src="/assets/images/signup-banner.png" width="580" height="580" alt="signup hero banner" class="w-100">
        </figure>
      </div>
    </section>

    <!-- Signup Form Section -->
    <section class="section signup-form" aria-label="signup form">
      <div class="container">
        <div class="form-container">
          <div class="form-header">
            <h2 class="h2 section-title">Create <span class="span">Account</span></h2>
            <p class="section-text">
              Fill in your details to create your account
            </p>
          </div>
          <form class="signup-form-element" @submit.prevent="handleSignup">
            <div class="form-row">
              <div class="form-group">
                <label for="firstName" class="form-label">First Name *</label>
                <input 
                  type="text" 
                  id="firstName" 
                  v-model="formData.firstName" 
                  name="firstName" 
                  class="form-input" 
                  required
                  placeholder="Enter your first name"
                >
              </div>
              <div class="form-group">
                <label for="lastName" class="form-label">Last Name *</label>
                <input 
                  type="text" 
                  id="lastName" 
                  v-model="formData.lastName" 
                  name="lastName" 
                  class="form-input" 
                  required
                  placeholder="Enter your last name"
                >
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="form-label">Email Address *</label>
              <input 
                type="email" 
                id="email" 
                v-model="formData.email" 
                name="email" 
                class="form-input" 
                required
                placeholder="Enter your email address"
              >
            </div>
            <div class="form-group">
              <label for="phone" class="form-label">Phone Number</label>
              <input 
                type="tel" 
                id="phone" 
                v-model="formData.phone" 
                name="phone" 
                class="form-input"
                placeholder="Enter your phone number"
              >
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password *</label>
              <div class="password-input">
                <input 
                  :type="showPassword ? 'text' : 'password'" 
                  id="password" 
                  v-model="formData.password" 
                  name="password" 
                  class="form-input" 
                  required
                  placeholder="Create a strong password"
                >
                <button 
                  type="button" 
                  class="password-toggle" 
                  @click="togglePassword"
                  :aria-label="showPassword ? 'Hide password' : 'Show password'"
                >
                  <ion-icon :name="showPassword ? 'eye-off-outline' : 'eye-outline'" aria-hidden="true"></ion-icon>
                </button>
              </div>
            </div>
            <div class="form-group">
              <label for="confirmPassword" class="form-label">Confirm Password *</label>
              <div class="password-input">
                <input 
                  :type="showConfirmPassword ? 'text' : 'password'" 
                  id="confirmPassword" 
                  v-model="formData.confirmPassword" 
                  name="confirmPassword" 
                  class="form-input" 
                  required
                  placeholder="Confirm your password"
                >
                <button 
                  type="button" 
                  class="password-toggle" 
                  @click="toggleConfirmPassword"
                  :aria-label="showConfirmPassword ? 'Hide password' : 'Show password'"
                >
                  <ion-icon :name="showConfirmPassword ? 'eye-off-outline' : 'eye-outline'" aria-hidden="true"></ion-icon>
                </button>
              </div>
            </div>
            <div class="form-group">
              <label for="role" class="form-label">Account Type *</label>
              <select 
                id="role" 
                v-model="formData.role" 
                name="role" 
                class="form-select"
                required
              >
                <option value="">Select your account type</option>
                <option value="student">Student</option>
                <option value="instructor">Instructor/Professor</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="interests" class="form-label">Learning Interests</label>
              <select 
                id="interests" 
                v-model="formData.interests" 
                name="interests" 
                class="form-select"
              >
                <option value="">Select your interests</option>
                <option value="web-development">Web Development</option>
                <option value="mobile-development">Mobile Development</option>
                <option value="data-science">Data Science</option>
                <option value="ui-ux-design">UI/UX Design</option>
                <option value="business">Business</option>
                <option value="languages">Languages</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-options">
              <label class="checkbox-label">
                <input 
                  type="checkbox" 
                  v-model="formData.agreeToTerms" 
                  name="agreeToTerms"
                  required
                >
                <span class="checkmark"></span>
                I agree to the <a href="#" class="link">Terms of Service</a> and <a href="#" class="link">Privacy Policy</a> *
              </label>
              <label class="checkbox-label">
                <input 
                  type="checkbox" 
                  v-model="formData.newsletter" 
                  name="newsletter"
                >
                <span class="checkmark"></span>
                Subscribe to our newsletter for updates and offers
              </label>
            </div>
            <button type="submit" class="btn has-before" :disabled="isSubmitting || !isFormValid">
              <span class="span">{{ isSubmitting ? 'Creating Account...' : 'Create Account' }}</span>
              <ion-icon name="person-add-outline" aria-hidden="true"></ion-icon>
            </button>
            <div class="divider">
              <span>or</span>
            </div>
            <div class="social-signup">
              <button type="button" class="social-btn google" @click="socialSignup('google')">
                <ion-icon name="logo-google" aria-hidden="true"></ion-icon>
                <span>Sign up with Google</span>
              </button>
              <button type="button" class="social-btn facebook" @click="socialSignup('facebook')">
                <ion-icon name="logo-facebook" aria-hidden="true"></ion-icon>
                <span>Sign up with Facebook</span>
              </button>
            </div>
            <div class="login-link">
              <p>Already have an account? <router-link to="/login" class="link">Sign in here</router-link></p>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'Signup',
  data() {
    return {
      isSubmitting: false,
      showPassword: false,
      showConfirmPassword: false,
      formData: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        password: '',
        confirmPassword: '',
        role: '',
        interests: '',
        agreeToTerms: false,
        newsletter: false
      }
    }
  },
  computed: {
    isFormValid() {
      return this.formData.firstName && 
             this.formData.lastName && 
             this.formData.email && 
             this.formData.password && 
             this.formData.confirmPassword && 
             this.formData.role &&
             this.formData.agreeToTerms &&
             this.formData.password === this.formData.confirmPassword;
    }
  },
  methods: {
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPassword() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
    async handleSignup() {
      if (!this.isFormValid) {
        if (!this.formData.role) {
          alert('Please select your account type (Student or Instructor/Professor).');
          return;
        }
        alert('Please fill in all required fields and ensure passwords match.');
        return;
      }

      this.isSubmitting = true;
      
      try {
        const response = await fetch('/api/signup', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            name: `${this.formData.firstName} ${this.formName}`,
            email: this.formData.email,
            phone: this.formData.phone,
            password: this.formData.password,
            password_confirmation: this.formData.confirmPassword,
            role: this.formData.role
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          // Store user data and token in localStorage
          localStorage.setItem('user', JSON.stringify(data.user));
          localStorage.setItem('token', data.token);
          
          // Reset form
          this.formData = {
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            password: '',
            confirmPassword: '',
            role: '',
            interests: '',
            agreeToTerms: false,
            newsletter: false
          };
          
          // Show success message and redirect to dashboard
          alert('Account created successfully! Welcome to EduWeb.');
          this.$router.push('/dashboard');
        } else {
          // Handle signup error
          const errorMessage = data.message || 'Signup failed. Please try again.';
          if (data.errors) {
            const errorDetails = Object.values(data.errors).flat().join('\n');
            alert(`${errorMessage}\n\n${errorDetails}`);
          } else {
            alert(errorMessage);
          }
        }
      } catch (error) {
        console.error('Signup error:', error);
        alert('An error occurred during signup. Please try again.');
      } finally {
        this.isSubmitting = false;
      }
    },
    socialSignup(provider) {
      console.log(`Signing up with ${provider}`);
      // Implement social signup logic here
      alert(`${provider} signup functionality would be implemented here`);
    }
  }
}
</script>

<style scoped>
.signup-hero {
  padding: 120px 0 80px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.signup-hero .container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.signup-hero .hero-banner {
  display: flex;
  justify-content: center;
  align-items: center;
}

.signup-hero .hero-banner img {
  max-width: 100%;
  height: auto;
  border-radius: 15px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.signup-hero .hero-title {
  font-size: clamp(2rem, 5vw, 3.5rem);
  line-height: 1.2;
  margin-bottom: 20px;
  font-weight: 700;
}

.signup-hero .hero-text {
  font-size: clamp(1rem, 2.5vw, 1.2rem);
  line-height: 1.6;
  margin-bottom: 30px;
  opacity: 0.9;
  max-width: 500px;
}

.signup-form {
  padding: 80px 0;
  background: var(--light-bg);
}

.form-container {
  max-width: 600px;
  margin: 0 auto;
  background: var(--white);
  padding: 50px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.form-header {
  text-align: center;
  margin-bottom: 40px;
}

.signup-form-element {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  margin-bottom: 8px;
  font-weight: 500;
  color: var(--text-color);
}

.form-input,
.form-select {
  padding: 12px 16px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-input:focus,
.form-select:focus {
  outline: none;
  border-color: var(--primary-color);
}

.password-input {
  position: relative;
}

.password-toggle {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: var(--text-light);
  padding: 4px;
}

.password-toggle:hover {
  color: var(--primary-color);
}

.form-options {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.checkbox-label {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  color: var(--text-color);
  line-height: 1.4;
}

.checkbox-label input[type="checkbox"] {
  display: none;
}

.checkmark {
  width: 18px;
  height: 18px;
  border: 2px solid var(--border-color);
  border-radius: 4px;
  position: relative;
  transition: all 0.3s ease;
  flex-shrink: 0;
  margin-top: 2px;
}

.checkbox-label input[type="checkbox"]:checked + .checkmark {
  background: var(--primary-color);
  border-color: var(--primary-color);
}

.checkbox-label input[type="checkbox"]:checked + .checkmark::after {
  content: '';
  position: absolute;
  left: 5px;
  top: 2px;
  width: 6px;
  height: 10px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.checkbox-label .link {
  color: var(--primary-color);
  text-decoration: none;
}

.checkbox-label .link:hover {
  text-decoration: underline;
}

.signup-form-element .btn {
  margin-top: 10px;
}

.signup-form-element .btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.divider {
  text-align: center;
  position: relative;
  margin: 30px 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: var(--border-color);
}

.divider span {
  background: var(--white);
  padding: 0 20px;
  color: var(--text-light);
  font-size: 0.9rem;
}

.social-signup {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.social-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 12px 20px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  background: var(--white);
  color: var(--text-color);
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.social-btn:hover {
  background: var(--light-bg);
  border-color: var(--primary-color);
}

.social-btn.google:hover {
  border-color: #db4437;
  color: #db4437;
}

.social-btn.facebook:hover {
  border-color: #4267B2;
  color: #4267B2;
}

.social-btn ion-icon {
  font-size: 1.2rem;
}

.login-link {
  text-align: center;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--border-color);
}

.login-link p {
  color: var(--text-light);
  font-size: 0.9rem;
}

.login-link .link {
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 500;
}

.login-link .link:hover {
  text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 1200px) {
  .signup-hero .container {
    gap: 40px;
  }
  
  .signup-hero .hero-title {
    font-size: clamp(2.5rem, 4vw, 3rem);
  }
  
  .signup-hero .hero-text {
    font-size: clamp(1rem, 2vw, 1.1rem);
  }
}

@media (max-width: 1024px) {
  .signup-hero {
    padding: 100px 0 60px;
    min-height: auto;
  }
  
  .signup-hero .container {
    grid-template-columns: 1fr;
    gap: 40px;
    text-align: center;
  }
  
  .signup-hero .hero-banner {
    order: -1;
  }
  
  .signup-hero .hero-text {
    max-width: 100%;
    margin: 0 auto 30px;
  }
}

@media (max-width: 768px) {
  .signup-hero {
    padding: 80px 0 50px;
  }
  
  .signup-hero .hero-title {
    font-size: clamp(2rem, 5vw, 2.5rem);
  }
  
  .signup-hero .hero-text {
    font-size: clamp(0.95rem, 2.5vw, 1rem);
  }
  
  .form-container {
    padding: 30px 20px;
    margin: 0 20px;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .form-options {
    gap: 12px;
  }
  
  .section-header {
    margin-bottom: 40px;
  }
  
  .section-title {
    font-size: clamp(1.8rem, 4vw, 2.2rem);
  }
  
  .section-text {
    font-size: clamp(0.9rem, 2vw, 1rem);
  }
}

@media (max-width: 480px) {
  .signup-hero {
    padding: 60px 0 40px;
  }
  
  .signup-hero .hero-title {
    font-size: clamp(1.8rem, 6vw, 2rem);
    line-height: 1.3;
  }
  
  .signup-hero .hero-text {
    font-size: clamp(0.9rem, 3vw, 0.95rem);
    line-height: 1.5;
  }
  
  .form-container {
    padding: clamp(15px, 4vw, 20px) clamp(12px, 3vw, 15px);
    margin: 0 10px;
  }
  
  .btn {
    padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px);
    font-size: clamp(0.85rem, 2.5vw, 0.9rem);
  }
  
  .section-title {
    font-size: clamp(1.6rem, 4vw, 1.8rem);
  }
  
  .section-text {
    font-size: clamp(0.85rem, 2.5vw, 0.95rem);
  }
}

@media (max-width: 360px) {
  .signup-hero .hero-title {
    font-size: clamp(1.6rem, 6vw, 1.8rem);
  }
  
  .signup-hero .hero-text {
    font-size: clamp(0.85rem, 3vw, 0.9rem);
  }
  
  .btn {
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
    font-size: clamp(0.8rem, 2.5vw, 0.85rem);
  }
  
  .form-container {
    padding: clamp(12px, 3vw, 15px) clamp(10px, 2.5vw, 12px);
  }
}
</style>
