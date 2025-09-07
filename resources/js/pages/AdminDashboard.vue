<template>
  <main>
    <!-- Admin Dashboard Header -->
    <section class="dashboard-header">
      <div class="container">
        <div class="user-welcome">
          <div class="user-avatar">
            <img :src="getImageUrl(user.avatar)" :alt="user.name" class="w-100">
          </div>
          <div class="user-info">
            <h1 class="welcome-title">Welcome back, Admin {{ user.name }}!</h1>
            <p class="user-email">{{ user.email }}</p>
            <p class="user-role">Administrator Dashboard</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-primary" @click="showAddUser = true">
              <ion-icon name="add-outline"></ion-icon>
              <span>Add New User</span>
            </button>
            <button class="btn btn-outline" @click="logout">
              <ion-icon name="log-out-outline"></ion-icon>
              <span>Logout</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Statistics Overview -->
    <section class="dashboard-stats">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Platform <span class="span">Overview</span></h2>
          <p class="section-text">Monitor platform performance and user statistics</p>
        </div>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.totalStudents }}</h3>
            <p class="stat-label">Total Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="school-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.totalInstructors }}</h3>
            <p class="stat-label">Total Instructors</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.totalCourses }}</h3>
            <p class="stat-label">Total Courses</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="cash-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">${{ stats.totalRevenue }}</h3>
            <p class="stat-label">Total Revenue</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Quick <span class="span">Actions</span></h2>
        </div>
        <div class="actions-grid">
          <div class="action-card" @click="showUserManagement = true">
            <div class="action-icon">
              <ion-icon name="people-circle-outline"></ion-icon>
            </div>
            <h3>Manage Users</h3>
            <p>Add, edit, delete users and manage roles</p>
          </div>
          <div class="action-card" @click="showCourseManagement = true">
            <div class="action-icon">
              <ion-icon name="library-outline"></ion-icon>
            </div>
            <h3>Manage Courses</h3>
            <p>Review and manage all platform courses</p>
          </div>
          <div class="action-card" @click="showAddUser = true">
            <div class="action-icon">
              <ion-icon name="add-circle-outline"></ion-icon>
            </div>
            <h3>Add New User</h3>
            <p>Create new student, instructor, or admin accounts</p>
          </div>
          <div class="action-card" @click="showPlatformSettings = true">
            <div class="action-icon">
              <ion-icon name="settings-outline"></ion-icon>
            </div>
            <h3>Platform Settings</h3>
            <p>Configure platform settings and policies</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Users -->
    <section class="recent-users">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Recent <span class="span">Users</span></h2>
          <button class="btn btn-outline" @click="showUserManagement = true">
            View All Users
          </button>
        </div>
        <div class="users-grid" v-if="recentUsers.length > 0">
          <div class="user-card" v-for="user in recentUsers" :key="user.id">
            <div class="user-avatar">
              <img :src="getImageUrl(user.avatar)" :alt="user.name" class="w-100">
              <div class="user-role-badge" :class="user.role">
                {{ user.role }}
              </div>
            </div>
            <div class="user-content">
              <h3 class="user-name">{{ user.name }}</h3>
              <p class="user-email">{{ user.email }}</p>
                             <div class="user-meta">
                 <span class="join-date">Joined: {{ formatDate(user.created_at) }}</span>
               </div>
              <div class="user-actions">
                <button class="btn btn-primary btn-sm" @click="editUser(user.id)">
                  <ion-icon name="create-outline"></ion-icon>
                  <span>Edit</span>
                </button>
                <button class="btn btn-outline btn-sm" @click="viewUserDetails(user.id)">
                  <ion-icon name="eye-outline"></ion-icon>
                  <span>View</span>
                </button>
                <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">
                  <ion-icon name="trash-outline"></ion-icon>
                  <span>Delete</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="empty-state" v-else>
          <div class="empty-icon">
            <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
          </div>
          <h3>No users yet</h3>
          <p>Start by adding your first user</p>
          <button class="btn btn-primary" @click="showAddUser = true">
            <ion-icon name="add-outline"></ion-icon>
            <span>Add Your First User</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Add User Modal -->
    <div class="modal-overlay" v-if="showAddUser" @click="showAddUser = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Add New User</h3>
          <button class="close-btn" @click="showAddUser = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="createUser">
          <div class="form-grid">
            <div class="form-group">
              <label for="userName">Full Name *</label>
              <input type="text" id="userName" v-model="userForm.name" required>
            </div>
            <div class="form-group">
              <label for="userEmail">Email *</label>
              <input type="email" id="userEmail" v-model="userForm.email" required>
            </div>
            <div class="form-group">
              <label for="userRole">Role *</label>
              <select id="userRole" v-model="userForm.role" required>
                <option value="">Select Role</option>
                <option value="student">Student</option>
                <option value="instructor">Instructor/Professor</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="form-group">
              <label for="userPassword">Password *</label>
              <input type="password" id="userPassword" v-model="userForm.password" required>
            </div>
            <div class="form-group">
              <label for="userPhone">Phone</label>
              <input type="tel" id="userPhone" v-model="userForm.phone">
            </div>
            <div class="form-group">
              <label for="userBio">Bio</label>
              <textarea id="userBio" v-model="userForm.bio" rows="3"></textarea>
            </div>
            <div class="form-group full-width">
              <label for="userImage">Profile Image</label>
              <input type="file" id="userImage" @change="handleUserImage" accept="image/*">
              <div class="image-preview" v-if="userImagePreview">
                <img :src="userImagePreview" alt="User image preview">
              </div>
            </div>
          </div>
          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="showAddUser = false">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary" :disabled="creatingUser">
              <span v-if="creatingUser">Creating...</span>
              <span v-else>Create User</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- User Management Modal -->
    <div class="modal-overlay" v-if="showUserManagement" @click="showUserManagement = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>User Management</h3>
          <button class="close-btn" @click="showUserManagement = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="user-management">
          <div class="filters">
            <input type="text" v-model="userSearch" placeholder="Search users..." class="search-input">
            <select v-model="roleFilter" class="role-filter">
              <option value="">All Roles</option>
              <option value="student">Students</option>
              <option value="instructor">Instructors</option>
              <option value="admin">Admins</option>
            </select>
          </div>
          
          <div class="users-table">
            <table>
              <thead>
                <tr>
                  <th>User</th>
                  <th>Role</th>
                  <th>Email</th>
                  <th>Joined</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in filteredUsers" :key="user.id">
                  <td class="user-cell">
                    <img :src="getImageUrl(user.avatar)" :alt="user.name" class="user-avatar-small">
                    <span>{{ user.name }}</span>
                  </td>
                  <td>
                    <span class="role-badge" :class="user.role">{{ user.role }}</span>
                  </td>
                  <td>{{ user.email }}</td>
                  <td>{{ formatDate(user.created_at) }}</td>
                  <td class="actions-cell">
                    <button class="btn btn-primary btn-sm" @click="editUser(user.id)">
                      <ion-icon name="create-outline"></ion-icon>
                    </button>
                    <button class="btn btn-outline btn-sm" @click="viewUserDetails(user.id)">
                      <ion-icon name="eye-outline"></ion-icon>
                    </button>
                    <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">
                      <ion-icon name="trash-outline"></ion-icon>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Course Management Modal -->
    <div class="modal-overlay" v-if="showCourseManagement" @click="showCourseManagement = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Course Management</h3>
          <button class="close-btn" @click="showCourseManagement = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="course-management">
          <div class="courses-table">
            <table>
              <thead>
                <tr>
                  <th>Course</th>
                  <th>Instructor</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Students</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="course in courses" :key="course.id">
                  <td class="course-cell">
                    <img :src="getCourseImage(course.image)" :alt="course.title" class="course-thumbnail">
                    <div>
                      <h4>{{ course.title }}</h4>
                      <p>{{ course.description }}</p>
                    </div>
                  </td>
                  <td>{{ course.instructor?.name || 'N/A' }}</td>
                  <td>{{ course.category?.name || 'N/A' }}</td>
                  <td>${{ course.price }}</td>
                  <td>{{ course.students_count || 0 }}</td>
                  <td>
                    <span class="status-badge" :class="course.status">{{ course.status }}</span>
                  </td>
                  <td class="actions-cell">
                    <button class="btn btn-primary btn-sm" @click="editCourse(course.id)">
                      <ion-icon name="create-outline"></ion-icon>
                    </button>
                    <button class="btn btn-outline btn-sm" @click="viewCourseDetails(course.id)">
                      <ion-icon name="eye-outline"></ion-icon>
                    </button>
                    <button class="btn btn-danger btn-sm" @click="deleteCourse(course.id)">
                      <ion-icon name="trash-outline"></ion-icon>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Platform Settings Modal -->
    <div class="modal-overlay" v-if="showPlatformSettings" @click="showPlatformSettings = false">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Platform Settings</h3>
          <button class="close-btn" @click="showPlatformSettings = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="savePlatformSettings">
          <div class="form-group">
            <label for="platformName">Platform Name</label>
            <input type="text" id="platformName" v-model="platformSettings.name">
          </div>
          <div class="form-group">
            <label for="platformEmail">Support Email</label>
            <input type="email" id="platformEmail" v-model="platformSettings.supportEmail">
          </div>
          <div class="form-group">
            <label for="maxFileSize">Max File Size (MB)</label>
            <input type="number" id="maxFileSize" v-model="platformSettings.maxFileSize" min="1" max="100">
          </div>
          <div class="form-group">
            <label for="maintenanceMode">Maintenance Mode</label>
            <select id="maintenanceMode" v-model="platformSettings.maintenanceMode">
              <option value="false">Disabled</option>
              <option value="true">Enabled</option>
            </select>
          </div>
          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="showPlatformSettings = false">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary" :disabled="savingSettings">
              <span v-if="savingSettings">Saving...</span>
              <span v-else>Save Settings</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'AdminDashboard',
  data() {
    return {
      user: {
        name: '',
        email: '',
        avatar: null
      },
      stats: {
        totalStudents: 0,
        totalInstructors: 0,
        totalCourses: 0,
        totalRevenue: 0
      },
      users: [],
      recentUsers: [],
      courses: [],
      showAddUser: false,
      showUserManagement: false,
      showCourseManagement: false,
      showPlatformSettings: false,
      creatingUser: false,
      savingSettings: false,
      userSearch: '',
      roleFilter: '',
      userForm: {
        name: '',
        email: '',
        role: '',
        password: '',
        phone: '',
        bio: '',
        image: null
      },
      userImagePreview: null,
      platformSettings: {
        name: 'EduWeb Platform',
        supportEmail: 'support@eduweb.com',
        maxFileSize: 10,
        maintenanceMode: false
      }
    }
  },
  computed: {
    filteredUsers() {
      let filtered = this.users;
      
      if (this.userSearch) {
        filtered = filtered.filter(user => 
          user.name.toLowerCase().includes(this.userSearch.toLowerCase()) ||
          user.email.toLowerCase().includes(this.userSearch.toLowerCase())
        );
      }
      
      if (this.roleFilter) {
        filtered = filtered.filter(user => user.role === this.roleFilter);
      }
      
      return filtered;
    }
  },
  mounted() {
    this.loadUserData();
    this.loadAdminData();
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
          
          // Check if user is admin
          if (data.user.role !== 'admin') {
            this.$router.push('/dashboard');
          }
        } else {
          this.$router.push('/login');
        }
      } catch (error) {
        console.error('Error loading user data:', error);
        this.$router.push('/login');
      }
    },

    async loadAdminData() {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch('/api/admin/dashboard', {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.stats = data.stats;
          this.users = data.users || [];
          this.recentUsers = data.recentUsers || [];
          this.courses = data.courses || [];
        }
      } catch (error) {
        console.error('Error loading admin data:', error);
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

    getCourseImage(imagePath) {
      if (!imagePath) {
        return 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80';
      }
      
      if (imagePath.startsWith('http')) {
        return imagePath;
      }
      
      return `/storage/${imagePath}`;
    },

    handleUserImage(event) {
      const file = event.target.files[0];
      if (file) {
        if (!file.type.startsWith('image/')) {
          alert('Please select an image file');
          return;
        }

        if (file.size > 5 * 1024 * 1024) {
          alert('Image size should be less than 5MB');
          return;
        }

        this.userForm.image = file;
        
        const reader = new FileReader();
        reader.onload = (e) => {
          this.userImagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },

    async createUser() {
      this.creatingUser = true;
      
      try {
        const formData = new FormData();
        formData.append('name', this.userForm.name);
        formData.append('email', this.userForm.email);
        formData.append('role', this.userForm.role);
        formData.append('password', this.userForm.password);
        formData.append('phone', this.userForm.phone);
        formData.append('bio', this.userForm.bio);
        
        if (this.userForm.image) {
          formData.append('image', this.userForm.image);
        }

        const token = localStorage.getItem('token');
        const response = await fetch('/api/admin/users', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('User created successfully!');
          this.showAddUser = false;
          this.resetUserForm();
          this.loadAdminData();
        } else {
          alert(data.message || 'Failed to create user');
        }
      } catch (error) {
        console.error('Error creating user:', error);
        alert('An error occurred while creating the user');
      } finally {
        this.creatingUser = false;
      }
    },

    resetUserForm() {
      this.userForm = {
        name: '',
        email: '',
        role: '',
        password: '',
        phone: '',
        bio: '',
        image: null
      };
      this.userImagePreview = null;
    },

    editUser(userId) {
      // Navigate to user edit page or show edit modal
      console.log('Edit user:', userId);
    },

    viewUserDetails(userId) {
      // Navigate to user details page or show details modal
      console.log('View user details:', userId);
    },

    async deleteUser(userId) {
      if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/admin/users/${userId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          alert('User deleted successfully!');
          this.loadAdminData();
        } else {
          alert('Failed to delete user');
        }
      } catch (error) {
        console.error('Error deleting user:', error);
        alert('An error occurred while deleting the user');
      }
    },

    editCourse(courseId) {
      // Navigate to course edit page
      console.log('Edit course:', courseId);
    },

    viewCourseDetails(courseId) {
      // Navigate to course details page
      console.log('View course details:', courseId);
    },

    async deleteCourse(courseId) {
      if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/admin/courses/${courseId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          alert('Course deleted successfully!');
          this.loadAdminData();
        } else {
          alert('Failed to delete course');
        }
      } catch (error) {
        console.error('Error deleting course:', error);
        alert('An error occurred while deleting the course');
      }
    },

    async savePlatformSettings() {
      this.savingSettings = true;
      
      try {
        const token = localStorage.getItem('token');
        const response = await fetch('/api/admin/settings', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(this.platformSettings)
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('Settings saved successfully!');
          this.showPlatformSettings = false;
        } else {
          alert(data.message || 'Failed to save settings');
        }
      } catch (error) {
        console.error('Error saving settings:', error);
        alert('An error occurred while saving settings');
      } finally {
        this.savingSettings = false;
      }
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString();
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
        localStorage.removeItem('token');
        localStorage.removeItem('user');
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

.header-actions {
  margin-left: auto;
  display: flex;
  gap: 15px;
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

.quick-actions {
  padding: 80px 0;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.action-card {
  background: white;
  padding: 40px 30px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  cursor: pointer;
}

.action-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.action-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  background: var(--kappel);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 2.5rem;
}

.action-card h3 {
  font-size: 1.3rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.action-card p {
  color: var(--gray-web);
  line-height: 1.6;
}

.recent-users {
  padding: 80px 0;
  background: var(--isabelline);
}

.users-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.user-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.user-card:hover {
  transform: translateY(-5px);
}

.user-avatar {
  position: relative;
  height: 200px;
}

.user-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.user-role-badge {
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

.user-role-badge.admin {
  background: #DC2626;
}

.user-role-badge.instructor {
  background: #10B981;
}

.user-role-badge.student {
  background: #3B82F6;
}

.user-content {
  padding: 25px;
}

.user-name {
  font-size: 1.2rem;
  font-weight: 600;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
  line-height: 1.4;
}

.user-email {
  color: var(--gray-web);
  margin-bottom: 20px;
  line-height: 1.5;
}

.user-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
  font-size: 0.9rem;
  color: var(--kappel);
}

.user-actions {
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

.btn-danger {
  background: #DC2626;
  color: white;
}

.btn-danger:hover {
  background: #B91C1C;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 0.8rem;
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
  max-width: 600px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-content.large {
  max-width: 800px;
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

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--eerie-black-1);
}

.form-group input,
.form-group select,
.form-group textarea {
  padding: 12px 16px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--kappel);
}

.image-preview {
  margin-top: 10px;
}

.image-preview img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
  border: 2px solid var(--kappel);
}

.modal-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 25px;
}

.user-management {
  padding: 20px 0;
}

.filters {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
}

.search-input,
.role-filter {
  padding: 10px 15px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 1rem;
}

.search-input {
  flex: 1;
}

.users-table {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.users-table table {
  width: 100%;
  border-collapse: collapse;
}

.users-table th,
.users-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #E5E7EB;
}

.users-table th {
  background: var(--isabelline);
  font-weight: 600;
  color: var(--eerie-black-1);
}

.user-cell {
  display: flex;
  align-items: center;
  gap: 15px;
}

.user-avatar-small {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.role-badge {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  color: white;
}

.role-badge.admin {
  background: #DC2626;
}

.role-badge.instructor {
  background: #10B981;
}

.role-badge.student {
  background: #3B82F6;
}

.status-badge {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  color: white;
}

.status-badge.active {
  background: #10B981;
}

.status-badge.inactive {
  background: #6B7280;
}

.status-badge.suspended {
  background: #F59E0B;
}

.actions-cell {
  display: flex;
  gap: 5px;
}

.course-management {
  padding: 20px 0;
}

.courses-table {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.course-cell {
  display: flex;
  align-items: center;
  gap: 15px;
}

.course-thumbnail {
  width: 60px;
  height: 40px;
  object-fit: cover;
  border-radius: 8px;
}

.course-cell h4 {
  margin: 0 0 5px 0;
  font-size: 1rem;
  color: var(--eerie-black-1);
}

.course-cell p {
  margin: 0;
  font-size: 0.9rem;
  color: var(--gray-web);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
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
}

/* Responsive Design */
@media (max-width: 768px) {
  .user-welcome {
    flex-direction: column;
    text-align: center;
  }
  
  .header-actions {
    margin-left: 0;
    margin-top: 20px;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
  }
  
  .filters {
    flex-direction: column;
  }
  
  .users-table {
    overflow-x: auto;
  }
  
  .actions-cell {
    flex-direction: column;
  }
}
</style>
