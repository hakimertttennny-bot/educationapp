<template>
  <main>
    <!-- Profile Header -->
    <section class="profile-header">
      <div class="container">
        <div class="profile-banner">
          <div class="profile-avatar">
            <img :src="user.avatar || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'" :alt="user.name" class="w-100">
            <button class="avatar-edit" @click="triggerAvatarUpload">
              <ion-icon name="camera-outline" aria-hidden="true"></ion-icon>
            </button>
            <input 
              type="file" 
              ref="avatarInput" 
              accept="image/*" 
              @change="handleAvatarChange" 
              style="display: none;"
            >
          </div>
          <div class="profile-info">
            <h1 class="profile-name">{{ user.name }}</h1>
            <p class="profile-email">{{ user.email }}</p>
            <p class="profile-role">{{ user.role }}</p>
            <div class="profile-stats">
              <div class="stat">
                <span class="stat-number">{{ stats.totalCourses }}</span>
                <span class="stat-label">Courses</span>
              </div>
              <div class="stat">
                <span class="stat-number">{{ stats.completedCourses }}</span>
                <span class="stat-label">Completed</span>
              </div>
              <div class="stat">
                <span class="stat-number">{{ stats.totalHours }}</span>
                <span class="stat-label">Hours</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Profile Content -->
    <section class="profile-content">
      <div class="container">
        <div class="profile-layout">
          <!-- Profile Navigation -->
          <div class="profile-nav">
            <button 
              class="nav-item" 
              :class="{ active: activeTab === 'personal' }"
              @click="activeTab = 'personal'"
            >
              <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
              <span>Personal Info</span>
            </button>
            <button 
              class="nav-item" 
              :class="{ active: activeTab === 'security' }"
              @click="activeTab = 'security'"
            >
              <ion-icon name="shield-outline" aria-hidden="true"></ion-icon>
              <span>Security</span>
            </button>
            <button 
              class="nav-item" 
              :class="{ active: activeTab === 'preferences' }"
              @click="activeTab = 'preferences'"
            >
              <ion-icon name="settings-outline" aria-hidden="true"></ion-icon>
              <span>Preferences</span>
            </button>
            <button 
              class="nav-item" 
              :class="{ active: activeTab === 'activity' }"
              @click="activeTab = 'activity'"
            >
              <ion-icon name="analytics-outline" aria-hidden="true"></ion-icon>
              <span>Activity</span>
            </button>
          </div>

          <!-- Profile Content Area -->
          <div class="profile-main">
            <!-- Personal Information Tab -->
            <div v-if="activeTab === 'personal'" class="tab-content">
              <div class="tab-header">
                <h2 class="tab-title">Personal <span class="span">Information</span></h2>
                <p class="tab-description">Update your personal details and profile information</p>
              </div>
              
              <form class="profile-form" @submit.prevent="updateProfile">
                <div class="form-row">
                  <div class="form-group">
                    <label for="name" class="form-label">Full Name *</label>
                    <input 
                      type="text" 
                      id="name" 
                      v-model="profileForm.name" 
                      class="form-input" 
                      required
                      placeholder="Enter your full name"
                    >
                  </div>
                  <div class="form-group">
                    <label for="email" class="form-label">Email Address *</label>
                    <input 
                      type="email" 
                      id="email" 
                      v-model="profileForm.email" 
                      class="form-input" 
                      required
                      placeholder="Enter your email address"
                    >
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input 
                      type="tel" 
                      id="phone" 
                      v-model="profileForm.phone" 
                      class="form-input" 
                      placeholder="Enter your phone number"
                    >
                  </div>
                  <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" v-model="profileForm.role" class="form-input">
                      <option value="student">Student</option>
                      <option value="instructor">Instructor</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="bio" class="form-label">Bio</label>
                  <textarea 
                    id="bio" 
                    v-model="profileForm.bio" 
                    class="form-textarea" 
                    rows="4"
                    placeholder="Tell us about yourself..."
                  ></textarea>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label for="website" class="form-label">Website</label>
                    <input 
                      type="url" 
                      id="website" 
                      v-model="profileForm.website" 
                      class="form-input" 
                      placeholder="https://yourwebsite.com"
                    >
                  </div>
                  <div class="form-group">
                    <label for="linkedin" class="form-label">LinkedIn</label>
                    <input 
                      type="url" 
                      id="linkedin" 
                      v-model="profileForm.linkedin" 
                      class="form-input" 
                      placeholder="https://linkedin.com/in/yourprofile"
                    >
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="twitter" class="form-label">Twitter</label>
                  <input 
                    type="url" 
                    id="twitter" 
                    v-model="profileForm.twitter" 
                    class="form-input" 
                    placeholder="https://twitter.com/yourhandle"
                  >
                </div>
                
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary" :disabled="isUpdating">
                    <span class="span">{{ isUpdating ? 'Updating...' : 'Update Profile' }}</span>
                    <ion-icon name="checkmark-outline" aria-hidden="true"></ion-icon>
                  </button>
                  <button type="button" class="btn btn-outline" @click="resetForm">
                    <span class="span">Reset</span>
                  </button>
                </div>
              </form>
            </div>

            <!-- Security Tab -->
            <div v-if="activeTab === 'security'" class="tab-content">
              <div class="tab-header">
                <h2 class="tab-title">Security <span class="span">Settings</span></h2>
                <p class="tab-description">Manage your password and account security</p>
              </div>
              
              <form class="profile-form" @submit.prevent="changePassword">
                <div class="form-group">
                  <label for="currentPassword" class="form-label">Current Password *</label>
                  <div class="password-input">
                    <input 
                      :type="showCurrentPassword ? 'text' : 'password'" 
                      id="currentPassword" 
                      v-model="passwordForm.currentPassword" 
                      class="form-input" 
                      required
                      placeholder="Enter your current password"
                    >
                    <button 
                      type="button" 
                      class="password-toggle" 
                      @click="showCurrentPassword = !showCurrentPassword"
                    >
                      <ion-icon :name="showCurrentPassword ? 'eye-off-outline' : 'eye-outline'" aria-hidden="true"></ion-icon>
                    </button>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="newPassword" class="form-label">New Password *</label>
                  <div class="password-input">
                    <input 
                      :type="showNewPassword ? 'text' : 'password'" 
                      id="newPassword" 
                      v-model="passwordForm.newPassword" 
                      class="form-input" 
                      required
                      placeholder="Enter your new password"
                    >
                    <button 
                      type="button" 
                      class="password-toggle" 
                      @click="showNewPassword = !showNewPassword"
                    >
                      <ion-icon :name="showNewPassword ? 'eye-off-outline' : 'eye-outline'" aria-hidden="true"></ion-icon>
                    </button>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="confirmPassword" class="form-label">Confirm New Password *</label>
                  <div class="password-input">
                    <input 
                      :type="showConfirmPassword ? 'text' : 'password'" 
                      id="confirmPassword" 
                      v-model="passwordForm.confirmPassword" 
                      class="form-input" 
                      required
                      placeholder="Confirm your new password"
                    >
                    <button 
                      type="button" 
                      class="password-toggle" 
                      @click="showConfirmPassword = !showConfirmPassword"
                    >
                      <ion-icon :name="showConfirmPassword ? 'eye-off-outline' : 'eye-outline'" aria-hidden="true"></ion-icon>
                    </button>
                  </div>
                </div>
                
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary" :disabled="isChangingPassword">
                    <span class="span">{{ isChangingPassword ? 'Changing...' : 'Change Password' }}</span>
                    <ion-icon name="shield-checkmark-outline" aria-hidden="true"></ion-icon>
                  </button>
                </div>
              </form>
            </div>

            <!-- Preferences Tab -->
            <div v-if="activeTab === 'preferences'" class="tab-content">
              <div class="tab-header">
                <h2 class="tab-title">Account <span class="span">Preferences</span></h2>
                <p class="tab-description">Customize your learning experience and notifications</p>
              </div>
              
              <div class="preferences-section">
                <h3 class="preferences-title">Notification Settings</h3>
                <div class="preferences-grid">
                  <div class="preference-item">
                    <div class="preference-info">
                      <h4>Course Updates</h4>
                      <p>Get notified when courses you're enrolled in are updated</p>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" v-model="preferences.courseUpdates">
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  
                  <div class="preference-item">
                    <div class="preference-info">
                      <h4>New Courses</h4>
                      <p>Receive notifications about new courses in your interests</p>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" v-model="preferences.newCourses">
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  
                  <div class="preference-item">
                    <div class="preference-info">
                      <h4>Email Notifications</h4>
                      <p>Receive important updates via email</p>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" v-model="preferences.emailNotifications">
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  
                  <div class="preference-item">
                    <div class="preference-info">
                      <h4>Push Notifications</h4>
                      <p>Get real-time notifications in your browser</p>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" v-model="preferences.pushNotifications">
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                </div>
              </div>
              
              <div class="preferences-section">
                <h3 class="preferences-title">Learning Preferences</h3>
                <div class="form-group">
                  <label for="timezone" class="form-label">Timezone</label>
                  <select id="timezone" v-model="preferences.timezone" class="form-input">
                    <option value="UTC">UTC</option>
                    <option value="America/New_York">Eastern Time</option>
                    <option value="America/Chicago">Central Time</option>
                    <option value="America/Denver">Mountain Time</option>
                    <option value="America/Los_Angeles">Pacific Time</option>
                    <option value="Europe/London">London</option>
                    <option value="Europe/Paris">Paris</option>
                    <option value="Asia/Tokyo">Tokyo</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="language" class="form-label">Preferred Language</label>
                  <select id="language" v-model="preferences.language" class="form-input">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                    <option value="it">Italian</option>
                    <option value="pt">Portuguese</option>
                    <option value="ru">Russian</option>
                    <option value="zh">Chinese</option>
                    <option value="ja">Japanese</option>
                  </select>
                </div>
              </div>
              
              <div class="form-actions">
                <button type="button" class="btn btn-primary" @click="savePreferences" :disabled="isSavingPreferences">
                  <span class="span">{{ isSavingPreferences ? 'Saving...' : 'Save Preferences' }}</span>
                  <ion-icon name="save-outline" aria-hidden="true"></ion-icon>
                </button>
              </div>
            </div>

            <!-- Activity Tab -->
            <div v-if="activeTab === 'activity'" class="tab-content">
              <div class="tab-header">
                <h2 class="tab-title">Learning <span class="span">Activity</span></h2>
                <p class="tab-description">Track your learning progress and achievements</p>
              </div>
              
              <div class="activity-stats">
                <div class="activity-card">
                  <div class="activity-icon">
                    <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>
                  </div>
                  <div class="activity-info">
                    <h4>Member Since</h4>
                    <p>{{ formatDate(user.created_at) }}</p>
                  </div>
                </div>
                
                <div class="activity-card">
                  <div class="activity-icon">
                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                  </div>
                  <div class="activity-info">
                    <h4>Last Login</h4>
                    <p>{{ formatDate(user.last_login) }}</p>
                  </div>
                </div>
                
                <div class="activity-card">
                  <div class="activity-icon">
                    <ion-icon name="trophy-outline" aria-hidden="true"></ion-icon>
                  </div>
                  <div class="activity-info">
                    <h4>Achievements</h4>
                    <p>{{ stats.achievements }} earned</p>
                  </div>
                </div>
              </div>
              
              <div class="recent-activity">
                <h3 class="activity-title">Recent Activity</h3>
                <div class="activity-list" v-if="recentActivity.length > 0">
                  <div class="activity-item" v-for="activity in recentActivity" :key="activity.id">
                    <div class="activity-icon" :class="activity.type">
                      <ion-icon :name="getActivityIcon(activity.type)" aria-hidden="true"></ion-icon>
                    </div>
                    <div class="activity-content">
                      <p class="activity-text">{{ activity.description }}</p>
                      <span class="activity-time">{{ formatTimeAgo(activity.created_at) }}</span>
                    </div>
                  </div>
                </div>
                <div class="empty-activity" v-else>
                  <ion-icon name="analytics-outline" aria-hidden="true"></ion-icon>
                  <p>No recent activity to show</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'Profile',
  data() {
    return {
      activeTab: 'personal',
      isUpdating: false,
      isChangingPassword: false,
      isSavingPreferences: false,
      showCurrentPassword: false,
      showNewPassword: false,
      showConfirmPassword: false,
      user: {
        id: 1,
        name: 'John Doe',
        email: 'john.doe@example.com',
        role: 'student',
        avatar: null,
        phone: '+1 (555) 123-4567',
        bio: 'Passionate learner and technology enthusiast.',
        website: 'https://johndoe.com',
        linkedin: 'https://linkedin.com/in/johndoe',
        twitter: 'https://twitter.com/johndoe',
        created_at: '2024-01-15T10:30:00Z',
        last_login: '2024-12-01T14:20:00Z'
      },
      stats: {
        totalCourses: 12,
        completedCourses: 8,
        totalHours: 156,
        achievements: 15
      },
      profileForm: {
        name: '',
        email: '',
        phone: '',
        role: '',
        bio: '',
        website: '',
        linkedin: '',
        twitter: ''
      },
      passwordForm: {
        currentPassword: '',
        newPassword: '',
        confirmPassword: ''
      },
      preferences: {
        courseUpdates: true,
        newCourses: true,
        emailNotifications: true,
        pushNotifications: false,
        timezone: 'America/New_York',
        language: 'en'
      },
      recentActivity: [
        {
          id: 1,
          type: 'course_completed',
          description: 'Completed "Advanced JavaScript Concepts"',
          created_at: '2024-12-01T10:30:00Z'
        },
        {
          id: 2,
          type: 'course_enrolled',
          description: 'Enrolled in "React Fundamentals"',
          created_at: '2024-11-30T15:45:00Z'
        },
        {
          id: 3,
          type: 'achievement_earned',
          description: 'Earned "Quick Learner" badge',
          created_at: '2024-11-29T09:20:00Z'
        },
        {
          id: 4,
          type: 'lesson_completed',
          description: 'Completed lesson 5 in "Vue.js Basics"',
          created_at: '2024-11-28T16:10:00Z'
        }
      ]
    }
  },
  mounted() {
    this.loadUserData();
    this.populateForm();
  },
  methods: {
    async loadUserData() {
      try {
        const response = await fetch('/api/user', {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include'
        });
        
        if (response.ok) {
          const data = await response.json();
          this.user = { ...this.user, ...data.user };
          this.populateForm();
        }
      } catch (error) {
        console.error('Error loading user data:', error);
      }
    },
    
    populateForm() {
      this.profileForm = {
        name: this.user.name || '',
        email: this.user.email || '',
        phone: this.user.phone || '',
        role: this.user.role || 'student',
        bio: this.user.bio || '',
        website: this.user.website || '',
        linkedin: this.user.linkedin || '',
        twitter: this.user.twitter || ''
      };
    },
    
    async updateProfile() {
      this.isUpdating = true;
      
      try {
        const response = await fetch('/api/profile', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include',
          body: JSON.stringify(this.profileForm)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
          this.user = { ...this.user, ...data.user };
          alert('Profile updated successfully!');
        } else {
          const errorMessage = data.message || 'Failed to update profile';
          if (data.errors) {
            const errorDetails = Object.values(data.errors).flat().join('\n');
            alert(`${errorMessage}\n\n${errorDetails}`);
          } else {
            alert(errorMessage);
          }
        }
      } catch (error) {
        console.error('Error updating profile:', error);
        alert('An error occurred while updating your profile. Please try again.');
      } finally {
        this.isUpdating = false;
      }
    },
    
    async changePassword() {
      if (this.passwordForm.newPassword !== this.passwordForm.confirmPassword) {
        alert('New password and confirm password do not match.');
        return;
      }
      
      this.isChangingPassword = true;
      
      try {
        const response = await fetch('/api/password', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include',
          body: JSON.stringify({
            current_password: this.passwordForm.currentPassword,
            new_password: this.passwordForm.newPassword,
            new_password_confirmation: this.passwordForm.confirmPassword
          })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
          alert('Password changed successfully!');
          this.passwordForm = {
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
          };
        } else {
          const errorMessage = data.message || 'Failed to change password';
          if (data.errors) {
            const errorDetails = Object.values(data.errors).flat().join('\n');
            alert(`${errorMessage}\n\n${errorDetails}`);
          } else {
            alert(errorMessage);
          }
        }
      } catch (error) {
        console.error('Error changing password:', error);
        alert('An error occurred while changing your password. Please try again.');
      } finally {
        this.isChangingPassword = false;
      }
    },
    
    async savePreferences() {
      this.isSavingPreferences = true;
      
      try {
        // Simulate API call for preferences
        await new Promise(resolve => setTimeout(resolve, 1000));
        alert('Preferences saved successfully!');
      } catch (error) {
        console.error('Error saving preferences:', error);
        alert('An error occurred while saving preferences. Please try again.');
      } finally {
        this.isSavingPreferences = false;
      }
    },
    
    resetForm() {
      this.populateForm();
    },
    
    triggerAvatarUpload() {
      this.$refs.avatarInput.click();
    },
    
    async handleAvatarChange(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      // Here you would typically upload the file to your server
      // For now, we'll just create a local URL
      const reader = new FileReader();
      reader.onload = (e) => {
        this.user.avatar = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    
    formatTimeAgo(dateString) {
      if (!dateString) return 'N/A';
      
      const now = new Date();
      const date = new Date(dateString);
      const diffInSeconds = Math.floor((now - date) / 1000);
      
      if (diffInSeconds < 60) return 'Just now';
      if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
      if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
      if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)} days ago`;
      
      return this.formatDate(dateString);
    },
    
    getActivityIcon(type) {
      const icons = {
        course_completed: 'checkmark-circle-outline',
        course_enrolled: 'add-circle-outline',
        achievement_earned: 'trophy-outline',
        lesson_completed: 'play-circle-outline',
        quiz_passed: 'document-text-outline'
      };
      return icons[type] || 'ellipse-outline';
    }
  }
}
</script>

<style scoped>
.profile-header {
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  padding: 60px 0;
  color: white;
}

.profile-banner {
  display: flex;
  align-items: center;
  gap: 40px;
  max-width: 800px;
  margin: 0 auto;
}

.profile-avatar {
  position: relative;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  overflow: hidden;
  border: 4px solid rgba(255, 255, 255, 0.3);
}

.profile-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.avatar-edit {
  position: absolute;
  bottom: 0;
  right: 0;
  background: var(--primary-color);
  border: none;
  border-radius: 50%;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
}

.avatar-edit:hover {
  background: var(--kappel);
  transform: scale(1.1);
}

.profile-info {
  flex: 1;
}

.profile-name {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 8px;
  line-height: 1.2;
}

.profile-email {
  font-size: 1.1rem;
  opacity: 0.9;
  margin-bottom: 4px;
}

.profile-role {
  text-transform: capitalize;
  font-weight: 500;
  margin-bottom: 20px;
  padding: 4px 12px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 20px;
  display: inline-block;
}

.profile-stats {
  display: flex;
  gap: 30px;
}

.stat {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 0.9rem;
  opacity: 0.8;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.profile-content {
  padding: 60px 0;
  background: var(--light-bg);
  min-height: 600px;
}

.profile-layout {
  display: grid;
  grid-template-columns: 250px 1fr;
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.profile-nav {
  background: var(--white);
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  height: fit-content;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  padding: 12px 16px;
  border: none;
  background: none;
  border-radius: 8px;
  color: var(--text-color);
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 8px;
}

.nav-item:hover {
  background: var(--light-bg);
  color: var(--primary-color);
}

.nav-item.active {
  background: var(--primary-color);
  color: white;
}

.nav-item ion-icon {
  font-size: 1.2rem;
}

.profile-main {
  background: var(--white);
  border-radius: 12px;
  padding: 40px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.tab-header {
  margin-bottom: 30px;
  text-align: center;
}

.tab-title {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 8px;
  color: var(--text-color);
}

.tab-description {
  color: var(--text-light);
  font-size: 1.1rem;
}

.profile-form {
  max-width: 600px;
  margin: 0 auto;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: var(--text-color);
}

.form-input,
.form-textarea {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
  background: var(--white);
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: var(--primary-color);
}

.form-textarea {
  resize: vertical;
  min-height: 100px;
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

.form-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-top: 30px;
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
}

.btn-primary {
  background: var(--primary-color);
  color: white;
}

.btn-primary:hover {
  background: var(--kappel);
  transform: translateY(-2px);
}

.btn-outline {
  background: transparent;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
}

.btn-outline:hover {
  background: var(--primary-color);
  color: white;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

/* Preferences Styles */
.preferences-section {
  margin-bottom: 40px;
}

.preferences-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 20px;
  color: var(--text-color);
}

.preferences-grid {
  display: grid;
  gap: 20px;
}

.preference-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background: var(--light-bg);
  border-radius: 8px;
}

.preference-info h4 {
  font-size: 1.1rem;
  font-weight: 500;
  margin-bottom: 4px;
  color: var(--text-color);
}

.preference-info p {
  color: var(--text-light);
  font-size: 0.9rem;
}

.toggle-switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.toggle-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 24px;
}

.toggle-slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .toggle-slider {
  background-color: var(--primary-color);
}

input:checked + .toggle-slider:before {
  transform: translateX(26px);
}

/* Activity Styles */
.activity-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.activity-card {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 20px;
  background: var(--light-bg);
  border-radius: 8px;
}

.activity-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: var(--primary-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
}

.activity-info h4 {
  font-size: 1rem;
  font-weight: 500;
  margin-bottom: 4px;
  color: var(--text-color);
}

.activity-info p {
  color: var(--text-light);
  font-size: 0.9rem;
}

.activity-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 20px;
  color: var(--text-color);
}

.activity-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.activity-item {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px;
  background: var(--light-bg);
  border-radius: 8px;
}

.activity-item .activity-icon {
  width: 40px;
  height: 40px;
  font-size: 1.2rem;
}

.activity-item .activity-icon.course_completed {
  background: #10b981;
}

.activity-item .activity-icon.course_enrolled {
  background: #3b82f6;
}

.activity-item .activity-icon.achievement_earned {
  background: #f59e0b;
}

.activity-item .activity-icon.lesson_completed {
  background: #8b5cf6;
}

.activity-content {
  flex: 1;
}

.activity-text {
  font-size: 1rem;
  color: var(--text-color);
  margin-bottom: 4px;
}

.activity-time {
  font-size: 0.85rem;
  color: var(--text-light);
}

.empty-activity {
  text-align: center;
  padding: 40px;
  color: var(--text-light);
}

.empty-activity ion-icon {
  font-size: 3rem;
  margin-bottom: 15px;
  opacity: 0.5;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .profile-layout {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  
  .profile-nav {
    order: 2;
  }
  
  .profile-main {
    order: 1;
  }
  
  .profile-nav {
    display: flex;
    overflow-x: auto;
    padding: 15px;
  }
  
  .nav-item {
    white-space: nowrap;
    margin-bottom: 0;
    margin-right: 10px;
  }
}

@media (max-width: 768px) {
  .profile-banner {
    flex-direction: column;
    text-align: center;
    gap: 30px;
  }
  
  .profile-name {
    font-size: 2rem;
  }
  
  .profile-stats {
    justify-content: center;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .form-actions {
    flex-direction: column;
  }
  
  .btn {
    width: 100%;
    justify-content: center;
  }
  
  .activity-stats {
    grid-template-columns: 1fr;
  }
  
  .preference-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }
}

@media (max-width: 480px) {
  .profile-header {
    padding: 40px 0;
  }
  
  .profile-content {
    padding: 40px 0;
  }
  
  .profile-main {
    padding: 20px;
  }
  
  .profile-name {
    font-size: 1.8rem;
  }
  
  .profile-stats {
    gap: 20px;
  }
  
  .stat-number {
    font-size: 1.2rem;
  }
  
  .tab-title {
    font-size: 1.5rem;
  }
}
</style>

