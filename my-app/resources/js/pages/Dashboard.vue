<template>
  <main>
    <!-- Dashboard Header -->
    <section class="dashboard-header">
      <div class="container">
        <div class="user-welcome">
          <div class="user-avatar">
            <img :src="user.avatar || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'" :alt="user.name" class="w-100">
          </div>
          <div class="user-info">
            <h1 class="welcome-title">Welcome back, {{ user.name }}!</h1>
            <p class="user-email">{{ user.email }}</p>
            <p class="user-role">{{ user.role }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Role-specific Dashboard Content -->
    
    <!-- Admin Dashboard -->
    <div v-if="user.role === 'admin'">
      <section class="dashboard-stats">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Admin <span class="span">Overview</span></h2>
            <p class="section-text">Manage your platform and monitor performance</p>
          </div>
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">{{ adminStats.totalStudents }}</h3>
              <p class="stat-label">Total Students</p>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="school-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">{{ adminStats.totalInstructors }}</h3>
              <p class="stat-label">Total Instructors</p>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">{{ adminStats.totalCourses }}</h3>
              <p class="stat-label">Total Courses</p>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="cash-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">${{ adminStats.totalRevenue }}</h3>
              <p class="stat-label">Total Revenue</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Admin Actions -->
      <section class="admin-actions">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Quick <span class="span">Actions</span></h2>
          </div>
          <div class="actions-grid">
            <div class="action-card">
              <h3>Manage Users</h3>
              <p>Add, edit, or delete users and manage roles</p>
              <button class="btn btn-primary" @click="showUserManagement = true">
                <span class="span">Manage Users</span>
                <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
            <div class="action-card">
              <h3>Manage Courses</h3>
              <p>Review and manage all platform courses</p>
              <button class="btn btn-primary" @click="showCourseManagement = true">
                <span class="span">Manage Courses</span>
                <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
            <div class="action-card">
              <h3>Add New User</h3>
              <p>Create new student, instructor, or admin accounts</p>
              <button class="btn btn-primary" @click="showAddUser = true">
                <span class="span">Add User</span>
                <ion-icon name="add-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Instructor Dashboard -->
    <div v-if="user.role === 'instructor'">
      <section class="instructor-redirect">
        <div class="container">
          <div class="redirect-content">
            <h2>Welcome to Your Instructor Dashboard!</h2>
            <p>You have been redirected to the dedicated instructor dashboard for better course management.</p>
            <button class="btn btn-primary" @click="goToInstructorDashboard">
              <ion-icon name="school-outline"></ion-icon>
              <span>Go to Instructor Dashboard</span>
            </button>
          </div>
        </div>
      </section>
      <section class="instructor-overview">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Instructor <span class="span">Overview</span></h2>
            <p class="section-text">Monitor your courses and student engagement</p>
          </div>
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">{{ instructorStats.totalCourses }}</h3>
              <p class="stat-label">Total Courses</p>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">{{ instructorStats.totalStudents }}</h3>
              <p class="stat-label">Total Students</p>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="cash-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">${{ instructorStats.totalRevenue }}</h3>
              <p class="stat-label">Total Revenue</p>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <ion-icon name="checkmark-circle-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="stat-number">{{ instructorStats.publishedCourses }}</h3>
              <p class="stat-label">Published Courses</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Instructor Actions -->
      <section class="instructor-actions">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Course <span class="span">Management</span></h2>
          </div>
          <div class="actions-grid">
            <div class="action-card">
              <h3>My Courses</h3>
              <p>View and manage your existing courses</p>
              <button class="btn btn-primary" @click="showMyCourses = true">
                <span class="span">View Courses</span>
                <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
            <div class="action-card">
              <h3>Create Course</h3>
              <p>Add a new course to your portfolio</p>
              <button class="btn btn-primary" @click="showCreateCourse = true">
                <span class="span">Create Course</span>
                <ion-icon name="add-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
            <div class="action-card">
              <h3>Student Enrollments</h3>
              <p>Track student progress and engagement</p>
              <button class="btn btn-primary" @click="showEnrollments = true">
                <span class="span">View Enrollments</span>
                <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>

          <!-- Student Dashboard -->
      <div v-if="user.role === 'student'">
        <section class="dashboard-stats">
          <div class="container">
            <div class="section-header">
              <h2 class="section-title">Learning <span class="span">Overview</span></h2>
              <p class="section-text">Track your learning progress and achievements</p>
            </div>
            <div class="stats-grid">
              <div class="stat-card">
                <div class="stat-icon">
                  <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
                </div>
                <h3 class="stat-number">{{ studentStats.enrolledCourses }}</h3>
                <p class="stat-label">Enrolled Courses</p>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <ion-icon name="play-circle-outline" aria-hidden="true"></ion-icon>
                </div>
                <h3 class="stat-number">{{ studentStats.inProgressCourses }}</h3>
                <p class="stat-label">In Progress</p>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <ion-icon name="checkmark-circle-outline" aria-hidden="true"></ion-icon>
                </div>
                <h3 class="stat-number">{{ studentStats.completedCourses }}</h3>
                <p class="stat-label">Completed</p>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                </div>
                <h3 class="stat-number">{{ studentStats.totalHours }}h</h3>
                <p class="stat-label">Total Hours</p>
              </div>
            </div>
          </div>
        </section>

        <!-- My Courses Section -->
        <section class="my-courses">
          <div class="container">
            <div class="section-header">
              <h2 class="section-title">My <span class="span">Courses</span></h2>
              <p class="section-text">Track your learning progress and continue where you left off</p>
            </div>
            
            <div class="courses-grid" v-if="enrolledCourses.length > 0">
              <div class="course-card" v-for="course in enrolledCourses" :key="course.id">
                <div class="course-image">
                  <img :src="course.course.image || 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80'" :alt="course.course.title" class="w-100">
                  <div class="course-status" :class="course.status">
                    {{ course.status.replace('_', ' ') }}
                  </div>
                </div>
                <div class="course-content">
                  <h3 class="course-title">{{ course.course.title }}</h3>
                  <p class="course-instructor">by {{ course.course.instructor?.user?.name || 'Unknown Instructor' }}</p>
                  <div class="course-progress">
                    <div class="progress-bar">
                      <div class="progress-fill" :style="{ width: course.progress + '%' }"></div>
                    </div>
                    <span class="progress-text">{{ course.progress }}% Complete</span>
                  </div>
                  <div class="course-actions">
                    <button class="btn btn-primary" @click="continueCourse(course.course_id)">
                      <span class="span">Continue</span>
                      <ion-icon name="play-outline" aria-hidden="true"></ion-icon>
                    </button>
                    <button class="btn btn-outline" @click="viewCourse(course.course_id)">
                      <span class="span">View Details</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="empty-state" v-else>
              <div class="empty-icon">
                <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
              </div>
              <h3>No courses enrolled yet</h3>
              <p>Start your learning journey by enrolling in your first course</p>
              <router-link to="/courses" class="btn btn-primary">
                <span class="span">Browse Courses</span>
                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
              </router-link>
            </div>
          </div>
        </section>

        <!-- Recommended Courses -->
        <section class="recommended-courses" v-if="recommendedCourses.length > 0">
          <div class="container">
            <div class="section-header">
              <h2 class="section-title">Recommended <span class="span">Courses</span></h2>
              <p class="section-text">Discover new courses that match your interests</p>
            </div>
            
            <div class="courses-grid">
              <div class="course-card" v-for="course in recommendedCourses" :key="course.id">
                <div class="course-image">
                  <img :src="course.image || 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80'" :alt="course.title" class="w-100">
                  <div class="course-price">${{ course.price }}</div>
                </div>
                <div class="course-content">
                  <h3 class="course-title">{{ course.title }}</h3>
                  <p class="course-instructor">by {{ course.instructor?.user?.name || 'Unknown Instructor' }}</p>
                  <p class="course-level">{{ course.level }}</p>
                  <div class="course-actions">
                    <button class="btn btn-primary" @click="enrollCourse(course.id)">
                      <span class="span">Enroll Now</span>
                      <ion-icon name="add-outline" aria-hidden="true"></ion-icon>
                    </button>
                    <button class="btn btn-outline" @click="addToWishlist(course.id)">
                      <span class="span">Add to Wishlist</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>



      <!-- Profile Section -->
    <section class="profile-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">My <span class="span">Profile</span></h2>
          <p class="section-text">Manage your account information and preferences</p>
        </div>
        
        <div class="profile-grid">
          <div class="profile-form">
            <form @submit.prevent="updateProfile">
              <!-- Profile Image Section -->
              <div class="profile-image-section">
                <div class="current-image">
                  <img :src="getImageUrl(user.avatar)" :alt="user.name">
                  <button type="button" class="change-image-btn" @click="triggerImageUpload">
                    <ion-icon name="camera-outline"></ion-icon>
                  </button>
                  <input 
                    ref="imageInput" 
                    type="file" 
                    accept="image/*" 
                    @change="handleImageChange" 
                    style="display: none"
                  >
                </div>
                <div class="image-preview" v-if="newImagePreview">
                  <img :src="newImagePreview" alt="New image preview">
                  <button type="button" class="remove-new-image" @click="removeNewImage">
                    <ion-icon name="close-outline"></ion-icon>
                  </button>
                </div>
              </div>

              <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" v-model="profileForm.name" required>
              </div>
              
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="profileForm.email" required>
              </div>
              
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" v-model="profileForm.phone">
              </div>
              
              <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" v-model="profileForm.bio" rows="4"></textarea>
              </div>
              
              <div class="form-group">
                <label for="website">Website</label>
                <input type="url" id="website" v-model="profileForm.website">
              </div>
              
              <button type="submit" class="btn btn-primary">
                <span class="span">Update Profile</span>
                <ion-icon name="save-outline" aria-hidden="true"></ion-icon>
              </button>
            </form>
          </div>
          
          <div class="profile-actions">
            <div class="action-card">
              <h3>Change Password</h3>
              <p>Update your account password for security</p>
              <button class="btn btn-outline" @click="showChangePassword = true">
                <span class="span">Change Password</span>
              </button>
            </div>
            
            <div class="action-card">
              <h3>Account Settings</h3>
              <p>Manage your account preferences and notifications</p>
              <button class="btn btn-outline">
                <span class="span">Settings</span>
              </button>
            </div>
            
            <div class="action-card danger">
              <h3>Delete Account</h3>
              <p>Permanently delete your account and all data</p>
              <button class="btn btn-danger" @click="confirmDeleteAccount">
                <span class="span">Delete Account</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Change Password Modal -->
    <div class="modal-overlay" v-if="showChangePassword" @click="showChangePassword = false">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Change Password</h3>
          <button class="close-btn" @click="showChangePassword = false">
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="changePassword">
          <div class="form-group">
            <label for="currentPassword">Current Password</label>
            <input type="password" id="currentPassword" v-model="passwordForm.currentPassword" required>
          </div>
          
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" id="newPassword" v-model="passwordForm.newPassword" required>
          </div>
          
          <div class="form-group">
            <label for="confirmPassword">Confirm New Password</label>
            <input type="password" id="confirmPassword" v-model="passwordForm.confirmPassword" required>
          </div>
          
          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="showChangePassword = false">
              <span class="span">Cancel</span>
            </button>
            <button type="submit" class="btn btn-primary">
              <span class="span">Change Password</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      user: {
        name: '',
        email: '',
        role: 'student',
        avatar: null
      },
      adminStats: {
        totalStudents: 0,
        totalInstructors: 0,
        totalCourses: 0,
        totalRevenue: 0
      },
      instructorStats: {
        totalCourses: 0,
        totalStudents: 0,
        totalRevenue: 0,
        publishedCourses: 0
      },
      studentStats: {
        enrolledCourses: 0,
        completedCourses: 0,
        inProgressCourses: 0,
        totalHours: 0
      },
      enrolledCourses: [],
      recommendedCourses: [],
      profileForm: {
        name: '',
        email: '',
        phone: '',
        bio: '',
        website: ''
      },
             passwordForm: {
         currentPassword: '',
         newPassword: '',
         confirmPassword: ''
       },
       showChangePassword: false,
       newImagePreview: null,
       newImageFile: null
    }
  },
  mounted() {
    this.loadUserData();
    this.loadRoleSpecificData();
  },
  methods: {
    async loadUserData() {
      try {
        const token = localStorage.getItem('token');
        if (!token) {
          this.$router.push('/login');
          return;
        }

        const response = await fetch('/api/user', {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.user = data.user;
          this.profileForm = {
            name: data.user.name || '',
            email: data.user.email || '',
            phone: data.user.phone || '',
            bio: data.user.bio || '',
            website: data.user.website || ''
          };
        } else {
          // If not authenticated, redirect to login
          this.$router.push('/login');
        }
      } catch (error) {
        console.error('Error loading user data:', error);
        this.$router.push('/login');
      }
    },
    async loadRoleSpecificData() {
      if (!this.user.id) return;

      try {
        let endpoint = '';
        switch (this.user.role) {
          case 'admin':
            endpoint = '/api/admin/dashboard';
            break;
          case 'instructor':
            endpoint = '/api/instructor/dashboard';
            break;
          case 'student':
            endpoint = '/api/student/dashboard';
            break;
        }

        if (endpoint) {
          const token = localStorage.getItem('token');
          const response = await fetch(endpoint, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`
            }
          });

          if (response.ok) {
            const data = await response.json();
            
            if (this.user.role === 'admin') {
              this.adminStats = data.stats;
            } else if (this.user.role === 'instructor') {
              this.instructorStats = data.stats;
            } else if (this.user.role === 'student') {
              this.studentStats = data.stats;
              this.enrolledCourses = data.enrolledCourses || [];
              this.recommendedCourses = data.recommendedCourses || [];
            }
          }
        }
      } catch (error) {
        console.error('Error loading role-specific data:', error);
      }
    },
    goToInstructorDashboard() {
      this.$router.push('/instructor/dashboard');
    },
    
    continueCourse(courseId) {
      // Navigate to course learning page
      this.$router.push(`/course/${courseId}/learn`);
    },
    viewCourse(courseId) {
      // Navigate to course details page
      this.$router.push(`/course/${courseId}`);
    },
    async enrollCourse(courseId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/student/courses/${courseId}/enroll`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('Successfully enrolled in course!');
          this.loadRoleSpecificData(); // Refresh data
        } else {
          alert(data.message || 'Failed to enroll in course');
        }
      } catch (error) {
        console.error('Enrollment error:', error);
        alert('An error occurred while enrolling');
      }
    },
    async addToWishlist(courseId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/student/wishlist/${courseId}`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('Course added to wishlist!');
        } else {
          alert(data.message || 'Failed to add to wishlist');
        }
      } catch (error) {
        console.error('Wishlist error:', error);
        alert('An error occurred while adding to wishlist');
      }
    },
         async updateProfile() {
       try {
         const formData = new FormData();
         formData.append('name', this.profileForm.name);
         formData.append('email', this.profileForm.email);
         formData.append('phone', this.profileForm.phone);
         formData.append('bio', this.profileForm.bio);
         formData.append('website', this.profileForm.website);
         
         if (this.newImageFile) {
           formData.append('image', this.newImageFile);
         }

                   const token = localStorage.getItem('token');
          const response = await fetch('/api/profile', {
            method: 'POST', // Using POST for FormData
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`
            },
            body: formData
          });

         const data = await response.json();

         if (response.ok && data.success) {
           this.user = { ...this.user, ...data.user };
           this.newImageFile = null;
           this.newImagePreview = null;
           alert('Profile updated successfully!');
         } else {
           alert(data.message || 'Failed to update profile');
         }
       } catch (error) {
         console.error('Profile update error:', error);
         alert('An error occurred while updating profile');
       }
     },
    async changePassword() {
      if (this.passwordForm.newPassword !== this.passwordForm.confirmPassword) {
        alert('New passwords do not match');
        return;
      }
      
      try {
        const token = localStorage.getItem('token');
        const response = await fetch('/api/password', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({
            current_password: this.passwordForm.currentPassword,
            new_password: this.passwordForm.newPassword,
            new_password_confirmation: this.passwordForm.confirmPassword
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('Password changed successfully!');
          this.showChangePassword = false;
          this.passwordForm = {
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
          };
        } else {
          alert(data.message || 'Failed to change password');
        }
      } catch (error) {
        console.error('Password change error:', error);
        alert('An error occurred while changing password');
      }
    },
         confirmDeleteAccount() {
       if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
         console.log('Deleting account');
         // API call would go here
       }
     },

     // Image handling methods
     triggerImageUpload() {
       this.$refs.imageInput.click();
     },

     handleImageChange(event) {
       const file = event.target.files[0];
       if (file) {
         // Validate file type
         if (!file.type.startsWith('image/')) {
           alert('Please select an image file');
           return;
         }

         // Validate file size (max 5MB)
         if (file.size > 5 * 1024 * 1024) {
           alert('Image size should be less than 5MB');
           return;
         }

         this.newImageFile = file;
         
         // Create preview
         const reader = new FileReader();
         reader.onload = (e) => {
           this.newImagePreview = e.target.result;
         };
         reader.readAsDataURL(file);
       }
     },

     removeNewImage() {
       this.newImageFile = null;
       this.newImagePreview = null;
       if (this.$refs.imageInput) {
         this.$refs.imageInput.value = '';
       }
     },

           getImageUrl(avatarPath) {
        if (!avatarPath) {
          return 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80';
        }
        
        if (avatarPath.startsWith('http')) {
          return avatarPath;
        }
        
        return `/storage/${avatarPath}`;
      },

      async logout() {
        try {
          const token = localStorage.getItem('token');
          await fetch('/api/logout', {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token}`
            }
          });
        } catch (error) {
          console.error('Logout error:', error);
        } finally {
          // Clear local storage
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          
          // Redirect to login
          this.$router.push('/login');
        }
      }
  }
}
</script>

<style scoped>
.dashboard-header {
  padding: 80px 0 60px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
}

.user-welcome {
  display: flex;
  align-items: center;
  gap: 30px;
}

.user-avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  overflow: hidden;
  border: 4px solid rgba(255, 255, 255, 0.3);
}

.user-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.welcome-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.user-email {
  font-size: 1.1rem;
  opacity: 0.9;
  margin-bottom: 5px;
}

.user-role {
  font-size: 1rem;
  opacity: 0.8;
  text-transform: capitalize;
}

.dashboard-stats {
  padding: 60px 0;
  background: var(--isabelline);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}

.stat-card {
  background: white;
  padding: 40px 30px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  background: var(--kappel);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 2rem;
}

.stat-number {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--kappel);
  margin-bottom: 10px;
}

.stat-label {
  color: var(--gray-web);
  font-size: 1.1rem;
}

.my-courses {
  padding: 80px 0;
}

.section-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-title {
  font-size: 2.5rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

 .section-text {
   font-size: 1.1rem;
   color: var(--gray-web);
   max-width: 600px;
   margin: 0 auto;
 }

 /* Profile Image Styles */
 .profile-image-section {
   text-align: center;
   margin-bottom: 30px;
   padding: 20px;
   background: var(--isabelline);
   border-radius: 15px;
 }

 .current-image {
   position: relative;
   display: inline-block;
   margin-bottom: 20px;
 }

 .current-image img {
   width: 120px;
   height: 120px;
   border-radius: 50%;
   object-fit: cover;
   border: 4px solid white;
   box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
 }

 .change-image-btn {
   position: absolute;
   bottom: 5px;
   right: 5px;
   background: var(--kappel);
   color: white;
   border: none;
   border-radius: 50%;
   width: 35px;
   height: 35px;
   cursor: pointer;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 16px;
   transition: all 0.3s ease;
 }

 .change-image-btn:hover {
   background: #0F766E;
   transform: scale(1.1);
 }

 .image-preview {
   position: relative;
   display: inline-block;
   margin-top: 15px;
 }

 .image-preview img {
   width: 100px;
   height: 100px;
   border-radius: 50%;
   object-fit: cover;
   border: 3px solid var(--kappel);
 }

 .remove-new-image {
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

 .remove-new-image:hover {
   background: #B91C1C;
 }

.courses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
}

.course-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.course-card:hover {
  transform: translateY(-5px);
}

.course-image {
  position: relative;
  height: 200px;
}

.course-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.course-status {
  position: absolute;
  top: 15px;
  right: 15px;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  color: white;
}

.course-status.enrolled {
  background: var(--kappel);
}

.course-status.in_progress {
  background: var(--selective-yellow);
  color: var(--eerie-black-1);
}

.course-status.completed {
  background: #10B981;
}

.course-content {
  padding: 25px;
}

.course-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
  line-height: 1.4;
}

.course-instructor {
  color: var(--kappel);
  font-size: 0.9rem;
  margin-bottom: 20px;
}

.course-progress {
  margin-bottom: 20px;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #E5E7EB;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 10px;
}

.progress-fill {
  height: 100%;
  background: var(--kappel);
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.9rem;
  color: var(--gray-web);
}

.course-actions {
  display: flex;
  gap: 10px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-primary {
  background: var(--kappel);
  color: white;
}

.btn-primary:hover {
  background: #0F766E;
}

.btn-outline {
  background: transparent;
  color: var(--kappel);
  border: 2px solid var(--kappel);
}

.btn-outline:hover {
  background: var(--kappel);
  color: white;
}

.empty-state {
  text-align: center;
  padding: 80px 20px;
}

.empty-icon {
  width: 100px;
  height: 100px;
  margin: 0 auto 30px;
  background: var(--isabelline);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--kappel);
  font-size: 3rem;
}

.empty-state h3 {
  font-size: 1.5rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.empty-state p {
  color: var(--gray-web);
  margin-bottom: 30px;
}

.profile-section {
  padding: 80px 0;
  background: var(--isabelline);
}

.profile-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 50px;
}

.profile-form {
  background: white;
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 25px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--eerie-black-1);
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--kappel);
}

.profile-actions {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.action-card {
  background: white;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.action-card h3 {
  font-size: 1.2rem;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
}

.action-card p {
  color: var(--gray-web);
  margin-bottom: 20px;
  line-height: 1.5;
}

.action-card.danger h3 {
  color: #DC2626;
}

.btn-danger {
  background: #DC2626;
  color: white;
}

.btn-danger:hover {
  background: #B91C1C;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 15px;
  padding: 30px;
  max-width: 500px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.modal-header h3 {
  font-size: 1.5rem;
  color: var(--eerie-black-1);
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: var(--gray-web);
}

.modal-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 25px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .user-welcome {
    flex-direction: column;
    text-align: center;
  }
  
  .welcome-title {
    font-size: 2rem;
  }
  
  .profile-grid {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  
  .courses-grid {
    grid-template-columns: 1fr;
  }
  
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .actions-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .course-actions {
    flex-direction: column;
  }
  
  .modal-content {
    padding: 20px;
  }
}

/* Instructor Redirect Section */
.instructor-redirect {
  padding: 80px 0;
  background: var(--isabelline);
}

.redirect-content {
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
}

.redirect-content h2 {
  font-size: 2.5rem;
  color: var(--eerie-black-1);
  margin-bottom: 20px;
}

.redirect-content p {
  font-size: 1.1rem;
  color: var(--gray-web);
  margin-bottom: 30px;
  line-height: 1.6;
}

/* New Styles for Role-specific Sections */
.admin-actions,
.instructor-actions {
  padding: 60px 0;
  background: var(--isabelline);
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.action-card {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s ease;
}

.action-card:hover {
  transform: translateY(-5px);
}

.action-card h3 {
  font-size: 1.3rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.action-card p {
  color: var(--gray-web);
  margin-bottom: 25px;
  line-height: 1.6;
}

.recommended-courses {
  padding: 80px 0;
  background: var(--isabelline);
}

.course-price {
  position: absolute;
  top: 15px;
  left: 15px;
  padding: 8px 15px;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
  background: var(--kappel);
  color: white;
}

.course-level {
  color: var(--gray-web);
  font-size: 0.9rem;
  margin-bottom: 20px;
  text-transform: capitalize;
}

.section-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-title {
  font-size: 2.5rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.section-text {
  font-size: 1.1rem;
  color: var(--gray-web);
  max-width: 600px;
  margin: 0 auto;
}
</style>
