<template>
  <main>
    <!-- Professor Dashboard Header -->
    <section class="dashboard-header">
      <div class="container">
        <div class="user-welcome">
          <div class="user-avatar">
            <img :src="getImageUrl(user.avatar)" :alt="user.name" class="w-100">
          </div>
          <div class="user-info">
            <h1 class="welcome-title">Welcome back, Professor {{ user.name }}!</h1>
            <p class="user-email">{{ user.email }}</p>
            <p class="user-role">Instructor Dashboard</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-primary" @click="showCreateCourse = true">
              <ion-icon name="add-outline"></ion-icon>
              <span>Create New Course</span>
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
          <h2 class="section-title">Your <span class="span">Overview</span></h2>
          <p class="section-text">Monitor your courses and student engagement</p>
        </div>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.totalCourses }}</h3>
            <p class="stat-label">Total Courses</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.totalStudents }}</h3>
            <p class="stat-label">Total Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="cash-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">${{ stats.totalRevenue }}</h3>
            <p class="stat-label">Total Revenue</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="checkmark-circle-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.publishedCourses }}</h3>
            <p class="stat-label">Published Courses</p>
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
          <div class="action-card" @click="showCreateCourse = true">
            <div class="action-icon">
              <ion-icon name="add-circle-outline"></ion-icon>
            </div>
            <h3>Create Course</h3>
            <p>Add a new course to your portfolio</p>
          </div>
          <div class="action-card" @click="showManageStudents = true">
            <div class="action-icon">
              <ion-icon name="people-circle-outline"></ion-icon>
            </div>
            <h3>Manage Students</h3>
            <p>Add, remove, and manage student enrollments</p>
          </div>
          <div class="action-card" @click="showCourseManagement = true">
            <div class="action-icon">
              <ion-icon name="library-outline"></ion-icon>
            </div>
            <h3>Manage Courses</h3>
            <p>Edit courses, add chapters, and manage content</p>
          </div>
          <div class="action-card" @click="showAnalytics = true">
            <div class="action-icon">
              <ion-icon name="analytics-outline"></ion-icon>
            </div>
            <h3>View Analytics</h3>
            <p>Track student progress and course performance</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Courses -->
    <section class="recent-courses">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Recent <span class="span">Courses</span></h2>
          <button class="btn btn-outline" @click="showCourseManagement = true">
            View All Courses
          </button>
        </div>
        <div class="courses-grid" v-if="recentCourses.length > 0">
          <div class="course-card" v-for="course in recentCourses" :key="course.id">
            <div class="course-image">
              <img :src="getCourseImage(course.image)" :alt="course.title" class="w-100">
              <div class="course-status" :class="course.status">
                {{ course.status }}
              </div>
            </div>
            <div class="course-content">
              <h3 class="course-title">{{ course.title }}</h3>
              <p class="course-description">{{ course.description }}</p>
              <div class="course-meta">
                <span class="students-count">
                  <ion-icon name="people-outline"></ion-icon>
                  {{ course.students_count }} students
                </span>
                <span class="chapters-count">
                  <ion-icon name="document-outline"></ion-icon>
                  {{ course.chapters_count }} chapters
                </span>
              </div>
              <div class="course-actions">
                <button class="btn btn-primary" @click="editCourse(course.id)">
                  <ion-icon name="create-outline"></ion-icon>
                  <span>Edit Course</span>
                </button>
                <button class="btn btn-outline" @click="manageChapters(course.id)">
                  <ion-icon name="document-outline"></ion-icon>
                  <span>Manage Chapters</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="empty-state" v-else>
          <div class="empty-icon">
            <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
          </div>
          <h3>No courses yet</h3>
          <p>Start by creating your first course</p>
          <button class="btn btn-primary" @click="showCreateCourse = true">
            <ion-icon name="add-outline"></ion-icon>
            <span>Create Your First Course</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Create Course Modal -->
    <div class="modal-overlay" v-if="showCreateCourse" @click="showCreateCourse = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Create New Course</h3>
          <button class="close-btn" @click="showCreateCourse = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="createCourse">
          <div class="form-grid">
            <div class="form-group">
              <label for="courseTitle">Course Title *</label>
              <input type="text" id="courseTitle" v-model="courseForm.title" required>
            </div>
            <div class="form-group">
              <label for="courseCategory">Category *</label>
              <select id="courseCategory" v-model="courseForm.category_id" required>
                <option value="">Select Category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                  {{ category.name }}
                </option>
              </select>
            </div>
            <div class="form-group full-width">
              <label for="courseDescription">Description *</label>
              <textarea id="courseDescription" v-model="courseForm.description" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <label for="coursePrice">Price ($)</label>
              <input type="number" id="coursePrice" v-model="courseForm.price" min="0" step="0.01">
            </div>
            <div class="form-group">
              <label for="courseLevel">Level</label>
              <select id="courseLevel" v-model="courseForm.level">
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
              </select>
            </div>
            <div class="form-group full-width">
              <label for="courseImage">Course Image</label>
              <input type="file" id="courseImage" @change="handleCourseImage" accept="image/*">
              <div class="image-preview" v-if="courseImagePreview">
                <img :src="courseImagePreview" alt="Course image preview">
              </div>
            </div>
          </div>
          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="showCreateCourse = false">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary" :disabled="creatingCourse">
              <span v-if="creatingCourse">Creating...</span>
              <span v-else>Create Course</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Manage Students Modal -->
    <div class="modal-overlay" v-if="showManageStudents" @click="showManageStudents = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Manage Students</h3>
          <button class="close-btn" @click="showManageStudents = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="students-management">
          <div class="add-student-section">
            <h4>Add Student to Course</h4>
            <div class="form-row">
              <select v-model="selectedCourse" class="form-select">
                <option value="">Select Course</option>
                <option v-for="course in courses" :key="course.id" :value="course.id">
                  {{ course.title }}
                </option>
              </select>
              <select v-model="selectedStudent" class="form-select">
                <option value="">Select Student</option>
                <option v-for="student in availableStudents" :key="student.id" :value="student.id">
                  {{ student.name }} ({{ student.email }})
                </option>
              </select>
              <button class="btn btn-primary" @click="addStudentToCourse" :disabled="!selectedCourse || !selectedStudent">
                Add Student
              </button>
            </div>
          </div>
          
          <div class="enrolled-students-section">
            <h4>Enrolled Students</h4>
            <div class="students-list" v-if="enrolledStudents.length > 0">
              <div class="student-item" v-for="enrollment in enrolledStudents" :key="enrollment.id">
                <div class="student-info">
                  <img :src="getImageUrl(enrollment.user.avatar)" :alt="enrollment.user.name" class="student-avatar">
                  <div>
                    <h5>{{ enrollment.user.name }}</h5>
                    <p>{{ enrollment.user.email }}</p>
                    <span class="course-name">{{ enrollment.course.title }}</span>
                  </div>
                </div>
                <div class="student-actions">
                  <span class="enrollment-date">Enrolled: {{ formatDate(enrollment.enrolled_at) }}</span>
                  <button class="btn btn-danger btn-sm" @click="removeStudentFromCourse(enrollment.id)">
                    Remove
                  </button>
                </div>
              </div>
            </div>
            <div class="empty-state" v-else>
              <p>No students enrolled yet</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Course Management Modal -->
    <div class="modal-overlay" v-if="showCourseManagement" @click="showCourseManagement = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Manage Your Courses</h3>
          <button class="close-btn" @click="showCourseManagement = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="courses-management">
          <div class="courses-list">
            <div class="course-item" v-for="course in courses" :key="course.id">
              <div class="course-header">
                <img :src="getCourseImage(course.image)" :alt="course.title" class="course-thumbnail">
                <div class="course-details">
                  <h4>{{ course.title }}</h4>
                  <p>{{ course.description }}</p>
                  <div class="course-stats">
                    <span>{{ course.students_count }} students</span>
                    <span>{{ course.chapters_count }} chapters</span>
                    <span>${{ course.price }}</span>
                  </div>
                </div>
              </div>
              <div class="course-actions">
                <button class="btn btn-primary" @click="editCourse(course.id)">
                  <ion-icon name="create-outline"></ion-icon>
                  Edit
                </button>
                <button class="btn btn-outline" @click="manageChapters(course.id)">
                  <ion-icon name="document-outline"></ion-icon>
                  Chapters
                </button>
                <button class="btn btn-outline" @click="viewStudents(course.id)">
                  <ion-icon name="people-outline"></ion-icon>
                  Students
                </button>
                <button class="btn btn-danger" @click="deleteCourse(course.id)">
                  <ion-icon name="trash-outline"></ion-icon>
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Analytics Modal -->
    <div class="modal-overlay" v-if="showAnalytics" @click="showAnalytics = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Course Analytics</h3>
          <button class="close-btn" @click="showAnalytics = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="analytics-content">
          <div class="analytics-grid">
            <div class="analytics-card">
              <h4>Student Progress</h4>
              <div class="progress-chart">
                <div class="progress-item" v-for="progress in studentProgress" :key="progress.course_id">
                  <span class="course-name">{{ progress.course_title }}</span>
                  <div class="progress-bar">
                    <div class="progress-fill" :style="{ width: progress.average_progress + '%' }"></div>
                  </div>
                  <span class="progress-text">{{ progress.average_progress }}%</span>
                </div>
              </div>
            </div>
            <div class="analytics-card">
              <h4>Revenue Overview</h4>
              <div class="revenue-stats">
                <div class="revenue-item">
                  <span class="label">This Month</span>
                  <span class="amount">${{ analytics.monthlyRevenue }}</span>
                </div>
                <div class="revenue-item">
                  <span class="label">Total Revenue</span>
                  <span class="amount">${{ analytics.totalRevenue }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'DashboardProf',
  data() {
    return {
      user: {
        name: '',
        email: '',
        avatar: null
      },
      stats: {
        totalCourses: 0,
        totalStudents: 0,
        totalRevenue: 0,
        publishedCourses: 0
      },
      courses: [],
      recentCourses: [],
      categories: [],
      enrolledStudents: [],
      availableStudents: [],
      studentProgress: [],
      analytics: {
        monthlyRevenue: 0,
        totalRevenue: 0
      },
      showCreateCourse: false,
      showManageStudents: false,
      showCourseManagement: false,
      showAnalytics: false,
      creatingCourse: false,
      selectedCourse: '',
      selectedStudent: '',
      courseForm: {
        title: '',
        description: '',
        category_id: '',
        price: 0,
        level: 'beginner',
        image: null
      },
      courseImagePreview: null
    }
  },
  mounted() {
    this.loadUserData();
    this.loadDashboardData();
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
        } else {
          this.$router.push('/login');
        }
      } catch (error) {
        console.error('Error loading user data:', error);
        this.$router.push('/login');
      }
    },

    async loadDashboardData() {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch('/api/instructor/dashboard', {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.stats = data.stats;
          this.courses = data.courses || [];
          this.recentCourses = data.recentCourses || [];
          this.categories = data.categories || [];
          this.enrolledStudents = data.enrolledStudents || [];
          this.availableStudents = data.availableStudents || [];
          this.studentProgress = data.studentProgress || [];
          this.analytics = data.analytics || {};
        }
      } catch (error) {
        console.error('Error loading dashboard data:', error);
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

    handleCourseImage(event) {
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

        this.courseForm.image = file;
        
        const reader = new FileReader();
        reader.onload = (e) => {
          this.courseImagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },

    async createCourse() {
      this.creatingCourse = true;
      
      try {
        const formData = new FormData();
        formData.append('title', this.courseForm.title);
        formData.append('description', this.courseForm.description);
        formData.append('category_id', this.courseForm.category_id);
        formData.append('price', this.courseForm.price);
        formData.append('level', this.courseForm.level);
        
        if (this.courseForm.image) {
          formData.append('image', this.courseForm.image);
        }

        const token = localStorage.getItem('token');
        const response = await fetch('/api/instructor/courses', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('Course created successfully!');
          this.showCreateCourse = false;
          this.resetCourseForm();
          this.loadDashboardData();
        } else {
          alert(data.message || 'Failed to create course');
        }
      } catch (error) {
        console.error('Error creating course:', error);
        alert('An error occurred while creating the course');
      } finally {
        this.creatingCourse = false;
      }
    },

    resetCourseForm() {
      this.courseForm = {
        title: '',
        description: '',
        category_id: '',
        price: 0,
        level: 'beginner',
        image: null
      };
      this.courseImagePreview = null;
    },

    async addStudentToCourse() {
      if (!this.selectedCourse || !this.selectedStudent) {
        alert('Please select both course and student');
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${this.selectedCourse}/enroll-student`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({
            student_id: this.selectedStudent
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          alert('Student enrolled successfully!');
          this.selectedStudent = '';
          this.loadDashboardData();
        } else {
          alert(data.message || 'Failed to enroll student');
        }
      } catch (error) {
        console.error('Error enrolling student:', error);
        alert('An error occurred while enrolling the student');
      }
    },

    async removeStudentFromCourse(enrollmentId) {
      if (!confirm('Are you sure you want to remove this student from the course?')) {
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/enrollments/${enrollmentId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          alert('Student removed successfully!');
          this.loadDashboardData();
        } else {
          alert('Failed to remove student');
        }
      } catch (error) {
        console.error('Error removing student:', error);
        alert('An error occurred while removing the student');
      }
    },

    editCourse(courseId) {
      this.$router.push(`/instructor/courses/${courseId}/edit`);
    },

    manageChapters(courseId) {
      this.$router.push(`/instructor/courses/${courseId}/chapters`);
    },

    viewStudents(courseId) {
      this.$router.push(`/instructor/courses/${courseId}/students`);
    },

    async deleteCourse(courseId) {
      if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${courseId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          alert('Course deleted successfully!');
          this.loadDashboardData();
        } else {
          alert('Failed to delete course');
        }
      } catch (error) {
        console.error('Error deleting course:', error);
        alert('An error occurred while deleting the course');
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

.recent-courses {
  padding: 80px 0;
  background: var(--isabelline);
}

.courses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  margin-top: 40px;
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

.course-status.published {
  background: #10B981;
}

.course-status.draft {
  background: #F59E0B;
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

.course-description {
  color: var(--gray-web);
  margin-bottom: 20px;
  line-height: 1.5;
}

.course-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
  font-size: 0.9rem;
  color: var(--kappel);
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

.students-management {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.add-student-section,
.enrolled-students-section {
  background: var(--isabelline);
  padding: 20px;
  border-radius: 10px;
}

.form-row {
  display: flex;
  gap: 15px;
  align-items: end;
}

.form-select {
  flex: 1;
}

.students-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.student-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.student-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.student-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
}

.student-info h5 {
  margin: 0 0 5px 0;
  color: var(--eerie-black-1);
}

.student-info p {
  margin: 0 0 5px 0;
  color: var(--gray-web);
  font-size: 0.9rem;
}

.course-name {
  background: var(--kappel);
  color: white;
  padding: 2px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
}

.student-actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

.enrollment-date {
  color: var(--gray-web);
  font-size: 0.9rem;
}

.courses-management {
  max-height: 500px;
  overflow-y: auto;
}

.courses-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.course-item {
  background: var(--isabelline);
  padding: 20px;
  border-radius: 10px;
}

.course-header {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.course-thumbnail {
  width: 100px;
  height: 70px;
  object-fit: cover;
  border-radius: 8px;
}

.course-details h4 {
  margin: 0 0 10px 0;
  color: var(--eerie-black-1);
}

.course-details p {
  margin: 0 0 15px 0;
  color: var(--gray-web);
  line-height: 1.5;
}

.course-stats {
  display: flex;
  gap: 20px;
  font-size: 0.9rem;
  color: var(--kappel);
}

.course-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.analytics-content {
  padding: 20px 0;
}

.analytics-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
}

.analytics-card {
  background: var(--isabelline);
  padding: 25px;
  border-radius: 10px;
}

.analytics-card h4 {
  margin: 0 0 20px 0;
  color: var(--eerie-black-1);
}

.progress-chart {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.progress-item {
  display: flex;
  align-items: center;
  gap: 15px;
}

.course-name {
  flex: 1;
  font-size: 0.9rem;
  color: var(--eerie-black-1);
}

.progress-bar {
  width: 100px;
  height: 8px;
  background: #E5E7EB;
  border-radius: 4px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: var(--kappel);
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.9rem;
  color: var(--kappel);
  font-weight: 600;
  min-width: 40px;
}

.revenue-stats {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.revenue-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background: white;
  border-radius: 8px;
}

.revenue-item .label {
  color: var(--gray-web);
  font-size: 0.9rem;
}

.revenue-item .amount {
  color: var(--kappel);
  font-size: 1.2rem;
  font-weight: 600;
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
  
  .form-row {
    flex-direction: column;
  }
  
  .analytics-grid {
    grid-template-columns: 1fr;
  }
  
  .course-actions {
    flex-direction: column;
  }
}
</style>


