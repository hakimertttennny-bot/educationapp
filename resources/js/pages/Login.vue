<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1>Welcome Back</h1>
        <p>Sign in to your account</p>
      </div>

      <!-- Login Form -->
      <form v-if="!showSignup" @submit.prevent="handleLogin" class="login-form">
        <div class="form-group">
          <label for="login-role">Role</label>
          <select id="login-role" v-model="loginForm.role" required>
            <option value="">Select your role</option>
            <option value="student">Student</option>
            <option value="instructor">Instructor/Professor</option>
            <option value="admin">Admin</option>
          </select>
          </div>

            <div class="form-group">
          <label for="email">Email</label>
              <input 
                type="email" 
                id="email" 
            v-model="loginForm.email" 
                required
            placeholder="Enter your email"
              >
            </div>

            <div class="form-group">
          <label for="password">Password</label>
                <input 
            type="password" 
                  id="password" 
            v-model="loginForm.password" 
                  required
                  placeholder="Enter your password"
                >
        </div>

        <button type="submit" class="btn btn-primary" :disabled="loading">
          <span v-if="loading">Signing in...</span>
          <span v-else>Sign In</span>
        </button>

        <div class="form-footer">
          <p>Don't have an account? 
            <a href="#" @click.prevent="showSignup = true">Sign up</a>
          </p>
        </div>
      </form>

      <!-- Signup Form -->
      <form v-else @submit.prevent="handleSignup" class="signup-form">
        <div class="form-group">
          <label for="signup-name">Full Name</label>
          <input 
            type="text" 
            id="signup-name" 
            v-model="signupForm.name" 
            required 
            placeholder="Enter your full name"
          >
        </div>

        <div class="form-group">
          <label for="signup-email">Email</label>
          <input 
            type="email" 
            id="signup-email" 
            v-model="signupForm.email" 
            required 
            placeholder="Enter your email"
          >
              </div>

        <div class="form-group">
          <label for="signup-role">Role</label>
          <select id="signup-role" v-model="signupForm.role" required>
            <option value="">Select your role</option>
            <option value="student">Student</option>
            <option value="instructor">Instructor/Professor</option>
            <option value="admin">Admin</option>
          </select>
            </div>

        <div class="form-group">
          <label for="signup-password">Password</label>
                <input 
            type="password" 
            id="signup-password" 
            v-model="signupForm.password" 
            required 
            placeholder="Create a password"
          >
            </div>

        <div class="form-group">
          <label for="signup-confirm-password">Confirm Password</label>
          <input 
            type="password" 
            id="signup-confirm-password" 
            v-model="signupForm.confirmPassword" 
            required 
            placeholder="Confirm your password"
          >
            </div>

        <!-- Profile Image Upload -->
        <div class="form-group">
          <label>Profile Image</label>
          <div class="image-upload">
            <div class="image-preview" v-if="imagePreview">
              <img :src="imagePreview" alt="Profile preview">
              <button type="button" class="remove-image" @click="removeImage">
                <ion-icon name="close-outline"></ion-icon>
              </button>
            </div>
            <div class="upload-area" v-else @click="triggerFileInput">
              <ion-icon name="camera-outline"></ion-icon>
              <p>Click to upload image</p>
              <input 
                ref="fileInput" 
                type="file" 
                accept="image/*" 
                @change="handleImageUpload" 
                style="display: none"
              >
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" :disabled="loading">
          <span v-if="loading">Creating account...</span>
          <span v-else>Create Account</span>
        </button>

        <div class="form-footer">
          <p>Already have an account? 
            <a href="#" @click.prevent="showSignup = false">Sign in</a>
          </p>
        </div>
      </form>

      <!-- Error Message -->
      <div v-if="error" class="error-message">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      showSignup: false,
      loading: false,
      error: '',
      loginForm: {
        email: '',
        password: '',
        role: ''
      },
      signupForm: {
        name: '',
        email: '',
        role: '',
        password: '',
        confirmPassword: '',
        image: null
      },
      imagePreview: null
    }
  },
  methods: {
    async handleLogin() {
       this.loading = true;
       this.error = '';

       // Validate role selection
       if (!this.loginForm.role) {
         this.error = 'Please select your role';
         this.loading = false;
         return;
       }
      
      try {
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
             'Accept': 'application/json'
           },
           body: JSON.stringify(this.loginForm)
         });

         const data = await response.json();

         if (response.ok && data.success) {
           // Store user data and token
           localStorage.setItem('user', JSON.stringify(data.user));
           localStorage.setItem('token', data.token);
           
           // Clear any previous errors
           this.error = '';
           
           // Redirect based on user role
           if (data.user.role === 'instructor') {
             this.$router.push('/instructor/dashboard');
           } else if (data.user.role === 'admin') {
             this.$router.push('/admin/dashboard');
           } else {
             this.$router.push('/dashboard');
           }
         } else {
           this.error = data.message || 'Login failed. Please check your credentials.';
         }
       } catch (error) {
         console.error('Login error:', error);
         this.error = 'An error occurred during login. Please try again.';
       } finally {
         this.loading = false;
       }
     },

    async handleSignup() {
      if (this.signupForm.password !== this.signupForm.confirmPassword) {
        this.error = 'Passwords do not match';
        return;
      }

      this.loading = true;
      this.error = '';

      try {
        const formData = new FormData();
        formData.append('name', this.signupForm.name);
        formData.append('email', this.signupForm.email);
        formData.append('role', this.signupForm.role);
        formData.append('password', this.signupForm.password);
        formData.append('password_confirmation', this.signupForm.confirmPassword);
        
        if (this.signupForm.image) {
          formData.append('image', this.signupForm.image);
        }

        const response = await fetch('/api/signup', {
          method: 'POST',
          headers: {
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
          // Store user data and token
          localStorage.setItem('user', JSON.stringify(data.user));
          localStorage.setItem('token', data.token);
          
          // Redirect based on user role
          if (data.user.role === 'instructor') {
            this.$router.push('/instructor/dashboard');
          } else if (data.user.role === 'admin') {
            this.$router.push('/admin/dashboard');
          } else {
            this.$router.push('/dashboard');
          }
        } else {
          this.error = data.message || 'Signup failed. Please try again.';
        }
      } catch (error) {
        console.error('Signup error:', error);
        this.error = 'An error occurred during signup. Please try again.';
      } finally {
        this.loading = false;
      }
    },

    triggerFileInput() {
      this.$refs.fileInput.click();
    },

    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
          this.error = 'Please select an image file';
          return;
        }

        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
          this.error = 'Image size should be less than 5MB';
          return;
        }

        this.signupForm.image = file;
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },

    removeImage() {
      this.signupForm.image = null;
      this.imagePreview = null;
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = '';
      }
    }
  }
}
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  padding: 20px;
}

.login-card {
  background: white;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 450px;
}

.login-header {
  text-align: center;
  margin-bottom: 30px;
}

.login-header h1 {
  font-size: 2.5rem;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
}

.login-header p {
  color: var(--gray-web);
  font-size: 1.1rem;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--eerie-black-1);
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 15px;
  border: 2px solid #E5E7EB;
  border-radius: 10px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: var(--kappel);
}

.btn {
  width: 100%;
  padding: 15px;
  border: none;
  border-radius: 10px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 20px;
}

.btn-primary {
  background: var(--kappel);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #0F766E;
  transform: translateY(-2px);
}

.btn-primary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.form-footer {
  text-align: center;
}

.form-footer a {
  color: var(--kappel);
  text-decoration: none;
  font-weight: 600;
}

.form-footer a:hover {
  text-decoration: underline;
}

.error-message {
  background: #FEE2E2;
  color: #DC2626;
  padding: 15px;
  border-radius: 10px;
  text-align: center;
  margin-top: 20px;
  border: 1px solid #FCA5A5;
}

/* Image Upload Styles */
.image-upload {
  margin-top: 10px;
}

.image-preview {
  position: relative;
  display: inline-block;
}

.image-preview img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid var(--kappel);
}

.remove-image {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #DC2626;
  color: white;
  border: none;
  border-radius: 50%;
  width: 25px;
  height: 25px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}

.upload-area {
  border: 2px dashed #D1D5DB;
  border-radius: 10px;
  padding: 30px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.upload-area:hover {
  border-color: var(--kappel);
  background: #F0FDF4;
}

.upload-area ion-icon {
  font-size: 2rem;
  color: var(--kappel);
  margin-bottom: 10px;
}

 .upload-area p {
   color: var(--gray-web);
   margin: 0;
 }

 /* Role Selection Styles */
 .form-group select {
   background: white;
   border: 2px solid #E5E7EB;
   color: var(--eerie-black-1);
 }

 .form-group select:focus {
   border-color: var(--kappel);
   outline: none;
 }

 .form-group select option {
   padding: 10px;
   background: white;
   color: var(--eerie-black-1);
 }

 /* Enhanced Form Group Styling */
 .form-group {
   position: relative;
 }

 .form-group label {
   font-weight: 600;
   color: var(--eerie-black-1);
   margin-bottom: 8px;
   display: block;
 }

 /* Role Badge Styling */
 .role-indicator {
   position: absolute;
   top: 50%;
   right: 15px;
   transform: translateY(-50%);
   background: var(--kappel);
   color: white;
   padding: 4px 8px;
   border-radius: 12px;
   font-size: 0.8rem;
   font-weight: 600;
 }

 /* Responsive Design */
 @media (max-width: 480px) {
   .login-card {
    padding: 30px 20px;
   }
   
   .login-header h1 {
     font-size: 2rem;
  }
}
</style>
