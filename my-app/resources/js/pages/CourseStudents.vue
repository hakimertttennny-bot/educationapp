<template>
  <main>
    <!-- Header -->
    <section class="page-header">
      <div class="container">
        <div class="header-content">
          <div class="back-button">
            <button class="btn btn-outline" @click="$router.go(-1)">
              <ion-icon name="arrow-back-outline"></ion-icon>
              <span>Back to Dashboard</span>
            </button>
          </div>
          <div class="course-info">
            <h1 class="page-title">Manage Students</h1>
            <p class="course-title">{{ course.title }}</p>
            <p class="course-description">{{ course.description }}</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-primary" @click="showAddStudent = true">
              <ion-icon name="add-outline"></ion-icon>
              <span>Add Student</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Statistics Overview -->
    <section class="stats-section">
      <div class="container">
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="people-outline"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.totalStudents }}</h3>
            <p class="stat-label">Total Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="checkmark-circle-outline"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.activeStudents }}</h3>
            <p class="stat-label">Active Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="time-outline"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.recentEnrollments }}</h3>
            <p class="stat-label">Recent Enrollments</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <ion-icon name="trending-up-outline"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stats.completionRate }}%</h3>
            <p class="stat-label">Completion Rate</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Students Management -->
    <section class="students-section">
      <div class="container">
        <div class="section-header">
          <h2>Course Students ({{ students.length }})</h2>
          <div class="header-controls">
            <div class="search-box">
              <input 
                type="text" 
                v-model="searchQuery" 
                placeholder="Search students..."
                @input="filterStudents"
              >
              <ion-icon name="search-outline"></ion-icon>
            </div>
            <select v-model="statusFilter" @change="filterStudents">
              <option value="">All Status</option>
              <option value="active">Active</option>
              <option value="completed">Completed</option>
              <option value="dropped">Dropped</option>
            </select>
          </div>
        </div>

        <div class="students-list" v-if="filteredStudents.length > 0">
          <div class="student-item" v-for="student in filteredStudents" :key="student.id">
            <div class="student-info">
              <div class="student-avatar">
                <img :src="getImageUrl(student.user.avatar)" :alt="student.user.name">
              </div>
              <div class="student-details">
                <h3 class="student-name">{{ student.user.name }}</h3>
                <p class="student-email">{{ student.user.email }}</p>
                <div class="student-meta">
                  <span class="enrollment-date">
                    <ion-icon name="calendar-outline"></ion-icon>
                    Enrolled: {{ formatDate(student.enrolled_at) }}
                  </span>
                  <span class="progress">
                    <ion-icon name="trending-up-outline"></ion-icon>
                    Progress: {{ student.progress || 0 }}%
                  </span>
                  <span class="status" :class="student.status">
                    {{ student.status }}
                  </span>
                </div>
              </div>
            </div>
            <div class="student-actions">
              <button class="btn btn-outline" @click="viewStudentProgress(student.id)">
                <ion-icon name="analytics-outline"></ion-icon>
                <span>Progress</span>
              </button>
              <button class="btn btn-outline" @click="sendMessage(student.id)">
                <ion-icon name="mail-outline"></ion-icon>
                <span>Message</span>
              </button>
              <button class="btn btn-danger" @click="removeStudent(student.id)">
                <ion-icon name="person-remove-outline"></ion-icon>
                <span>Remove</span>
              </button>
            </div>
          </div>
        </div>

        <div class="empty-state" v-else>
          <div class="empty-icon">
            <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
          </div>
          <h3>No students found</h3>
          <p v-if="searchQuery || statusFilter">Try adjusting your search or filter criteria</p>
          <p v-else>Start by adding students to your course</p>
          <button class="btn btn-primary" @click="showAddStudent = true">
            <ion-icon name="add-outline"></ion-icon>
            <span>Add Your First Student</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Add Student Modal -->
    <div class="modal-overlay" v-if="showAddStudent" @click="showAddStudent = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Add Student to Course</h3>
          <button class="close-btn" @click="showAddStudent = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="add-student-content">
          <div class="search-students">
            <h4>Search Available Students</h4>
            <div class="search-input">
              <input 
                type="text" 
                v-model="studentSearchQuery" 
                placeholder="Search by name or email..."
                @input="searchAvailableStudents"
              >
              <ion-icon name="search-outline"></ion-icon>
            </div>
            
            <div class="available-students" v-if="availableStudents.length > 0">
              <h5>Available Students</h5>
              <div class="student-options">
                <div 
                  class="student-option" 
                  v-for="student in availableStudents" 
                  :key="student.id"
                  @click="selectStudent(student)"
                >
                  <div class="student-option-info">
                    <img :src="getImageUrl(student.avatar)" :alt="student.name" class="student-option-avatar">
                    <div>
                      <h6>{{ student.name }}</h6>
                      <p>{{ student.email }}</p>
                    </div>
                  </div>
                  <button class="btn btn-primary btn-sm" @click.stop="enrollStudent(student.id)">
                    Enroll
                  </button>
                </div>
              </div>
            </div>
            
            <div class="no-students" v-else-if="studentSearchQuery && !searchingStudents">
              <p>No students found matching your search criteria.</p>
            </div>
          </div>

          <div class="bulk-enrollment">
            <h4>Bulk Enrollment</h4>
            <div class="bulk-form">
              <div class="form-group">
                <label for="bulkEmails">Student Emails (one per line)</label>
                <textarea 
                  id="bulkEmails" 
                  v-model="bulkEmails" 
                  rows="4" 
                  placeholder="student1@example.com&#10;student2@example.com&#10;student3@example.com"
                ></textarea>
              </div>
              <button class="btn btn-primary" @click="bulkEnrollStudents" :disabled="!bulkEmails.trim()">
                <ion-icon name="people-outline"></ion-icon>
                <span>Enroll All Students</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Student Progress Modal -->
    <div class="modal-overlay" v-if="showStudentProgress" @click="showStudentProgress = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Student Progress</h3>
          <button class="close-btn" @click="showStudentProgress = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="student-progress" v-if="selectedStudent">
          <div class="student-header">
            <img :src="getImageUrl(selectedStudent.user.avatar)" :alt="selectedStudent.user.name" class="progress-avatar">
            <div>
              <h4>{{ selectedStudent.user.name }}</h4>
              <p>{{ selectedStudent.user.email }}</p>
              <span class="enrollment-date">Enrolled: {{ formatDate(selectedStudent.enrolled_at) }}</span>
            </div>
          </div>
          
          <div class="progress-overview">
            <div class="progress-stats">
              <div class="progress-stat">
                <span class="label">Overall Progress</span>
                <span class="value">{{ selectedStudent.progress || 0 }}%</span>
              </div>
              <div class="progress-stat">
                <span class="label">Chapters Completed</span>
                <span class="value">{{ selectedStudent.completed_chapters || 0 }}/{{ totalChapters }}</span>
              </div>
              <div class="progress-stat">
                <span class="label">Lessons Completed</span>
                <span class="value">{{ selectedStudent.completed_lessons || 0 }}/{{ totalLessons }}</span>
              </div>
            </div>
          </div>

          <div class="chapter-progress" v-if="chapterProgress.length > 0">
            <h5>Chapter Progress</h5>
            <div class="progress-list">
              <div class="progress-item" v-for="chapter in chapterProgress" :key="chapter.id">
                <div class="progress-info">
                  <h6>{{ chapter.title }}</h6>
                  <span class="progress-text">{{ chapter.progress }}% complete</span>
                </div>
                <div class="progress-bar">
                  <div class="progress-fill" :style="{ width: chapter.progress + '%' }"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Send Message Modal -->
    <div class="modal-overlay" v-if="showSendMessage" @click="showSendMessage = false">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Send Message to Student</h3>
          <button class="close-btn" @click="showSendMessage = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="sendStudentMessage">
          <div class="form-group">
            <label for="messageSubject">Subject</label>
            <input type="text" id="messageSubject" v-model="messageForm.subject" required>
          </div>
          <div class="form-group">
            <label for="messageContent">Message</label>
            <textarea id="messageContent" v-model="messageForm.content" rows="6" required></textarea>
          </div>
          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="showSendMessage = false">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary" :disabled="sendingMessage">
              <span v-if="sendingMessage">Sending...</span>
              <span v-else>Send Message</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'CourseStudents',
  data() {
    return {
      course: {
        id: null,
        title: '',
        description: ''
      },
      students: [],
      filteredStudents: [],
      availableStudents: [],
      chapterProgress: [],
      totalChapters: 0,
      totalLessons: 0,
      stats: {
        totalStudents: 0,
        activeStudents: 0,
        recentEnrollments: 0,
        completionRate: 0
      },
      searchQuery: '',
      statusFilter: '',
      studentSearchQuery: '',
      searchingStudents: false,
      showAddStudent: false,
      showStudentProgress: false,
      showSendMessage: false,
      selectedStudent: null,
      bulkEmails: '',
      sendingMessage: false,
      messageForm: {
        subject: '',
        content: ''
      }
    }
  },
  mounted() {
    this.loadData();
  },
  methods: {
    async loadData() {
      const courseId = this.$route.params.courseId;
      await this.loadCourseData(courseId);
      await this.loadStudents(courseId);
      await this.loadStats(courseId);
    },

    async loadCourseData(courseId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${courseId}`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.course = data.course;
        }
      } catch (error) {
        console.error('Error loading course data:', error);
      }
    },

    async loadStudents(courseId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${courseId}/students`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.students = data.students || [];
          this.filteredStudents = [...this.students];
        }
      } catch (error) {
        console.error('Error loading students:', error);
      }
    },

    async loadStats(courseId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${courseId}/stats`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.stats = data.stats || {};
        }
      } catch (error) {
        console.error('Error loading stats:', error);
      }
    },

    filterStudents() {
      let filtered = [...this.students];
      
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(student => 
          student.user.name.toLowerCase().includes(query) ||
          student.user.email.toLowerCase().includes(query)
        );
      }
      
      if (this.statusFilter) {
        filtered = filtered.filter(student => student.status === this.statusFilter);
      }
      
      this.filteredStudents = filtered;
    },

    async searchAvailableStudents() {
      if (!this.studentSearchQuery.trim()) {
        this.availableStudents = [];
        return;
      }

      this.searchingStudents = true;
      
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/students/search?q=${encodeURIComponent(this.studentSearchQuery)}`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.availableStudents = data.students || [];
        }
      } catch (error) {
        console.error('Error searching students:', error);
      } finally {
        this.searchingStudents = false;
      }
    },

    async enrollStudent(studentId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${this.course.id}/enroll-student`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({ student_id: studentId })
        });

        if (response.ok) {
          alert('Student enrolled successfully!');
          this.loadStudents(this.course.id);
          this.loadStats(this.course.id);
          this.availableStudents = this.availableStudents.filter(s => s.id !== studentId);
        } else {
          alert('Failed to enroll student');
        }
      } catch (error) {
        console.error('Error enrolling student:', error);
        alert('An error occurred while enrolling the student');
      }
    },

    async bulkEnrollStudents() {
      const emails = this.bulkEmails.split('\n').map(email => email.trim()).filter(email => email);
      
      if (emails.length === 0) {
        alert('Please enter at least one email address');
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${this.course.id}/bulk-enroll`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({ emails })
        });

        if (response.ok) {
          const data = await response.json();
          alert(`Successfully enrolled ${data.enrolled_count} students!`);
          this.bulkEmails = '';
          this.loadStudents(this.course.id);
          this.loadStats(this.course.id);
        } else {
          alert('Failed to enroll students');
        }
      } catch (error) {
        console.error('Error bulk enrolling students:', error);
        alert('An error occurred while enrolling students');
      }
    },

    async removeStudent(enrollmentId) {
      if (!confirm('Are you sure you want to remove this student from the course? This action cannot be undone.')) {
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
          this.loadStudents(this.course.id);
          this.loadStats(this.course.id);
        } else {
          alert('Failed to remove student');
        }
      } catch (error) {
        console.error('Error removing student:', error);
        alert('An error occurred while removing the student');
      }
    },

    async viewStudentProgress(enrollmentId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/enrollments/${enrollmentId}/progress`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.selectedStudent = data.enrollment;
          this.chapterProgress = data.chapterProgress || [];
          this.totalChapters = data.totalChapters || 0;
          this.totalLessons = data.totalLessons || 0;
          this.showStudentProgress = true;
        }
      } catch (error) {
        console.error('Error loading student progress:', error);
      }
    },

    sendMessage(enrollmentId) {
      this.selectedStudent = this.students.find(s => s.id === enrollmentId);
      this.messageForm = {
        subject: `Message from ${this.course.title}`,
        content: ''
      };
      this.showSendMessage = true;
    },

    async sendStudentMessage() {
      this.sendingMessage = true;
      
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/students/${this.selectedStudent.user.id}/message`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(this.messageForm)
        });

        if (response.ok) {
          alert('Message sent successfully!');
          this.showSendMessage = false;
          this.messageForm = { subject: '', content: '' };
        } else {
          alert('Failed to send message');
        }
      } catch (error) {
        console.error('Error sending message:', error);
        alert('An error occurred while sending the message');
      } finally {
        this.sendingMessage = false;
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

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString();
    }
  }
}
</script>

<style scoped>
.page-header {
  padding: 60px 0 40px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
}

.header-content {
  display: flex;
  align-items: center;
  gap: 30px;
}

.back-button {
  flex-shrink: 0;
}

.course-info {
  flex: 1;
}

.page-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.course-title {
  font-size: 1.3rem;
  font-weight: 600;
  margin-bottom: 5px;
  opacity: 0.9;
}

.course-description {
  font-size: 1rem;
  opacity: 0.8;
  max-width: 600px;
}

.header-actions {
  flex-shrink: 0;
}

.stats-section {
  padding: 40px 0;
  background: var(--isabelline);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.stat-card {
  background: white;
  padding: 25px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-icon {
  width: 60px;
  height: 60px;
  margin: 0 auto 15px;
  background: var(--kappel);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: var(--kappel);
  margin-bottom: 8px;
}

.stat-label {
  color: var(--gray-web);
  font-size: 0.9rem;
}

.students-section {
  padding: 60px 0;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
  flex-wrap: wrap;
  gap: 20px;
}

.section-header h2 {
  font-size: 2rem;
  color: var(--eerie-black-1);
  margin: 0;
}

.header-controls {
  display: flex;
  gap: 15px;
  align-items: center;
}

.search-box {
  position: relative;
}

.search-box input {
  padding: 10px 40px 10px 15px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 0.9rem;
  width: 250px;
}

.search-box ion-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--gray-web);
}

.header-controls select {
  padding: 10px 15px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 0.9rem;
  background: white;
}

.students-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.student-item {
  background: white;
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.student-item:hover {
  transform: translateY(-2px);
}

.student-info {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.student-avatar {
  flex-shrink: 0;
}

.student-avatar img {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
}

.student-details {
  flex: 1;
}

.student-name {
  font-size: 1.2rem;
  font-weight: 600;
  color: var(--eerie-black-1);
  margin-bottom: 5px;
}

.student-email {
  color: var(--gray-web);
  margin-bottom: 15px;
}

.student-meta {
  display: flex;
  gap: 20px;
  font-size: 0.9rem;
  color: var(--kappel);
}

.student-meta span {
  display: flex;
  align-items: center;
  gap: 5px;
}

.status {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.status.active {
  background: #10B981;
  color: white;
}

.status.completed {
  background: #3B82F6;
  color: white;
}

.status.dropped {
  background: #EF4444;
  color: white;
}

.student-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
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

.add-student-content {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.search-students h4,
.bulk-enrollment h4 {
  font-size: 1.2rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.search-input {
  position: relative;
  margin-bottom: 20px;
}

.search-input input {
  width: 100%;
  padding: 12px 40px 12px 15px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 1rem;
}

.search-input ion-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--gray-web);
}

.available-students h5 {
  font-size: 1rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.student-options {
  display: flex;
  flex-direction: column;
  gap: 15px;
  max-height: 300px;
  overflow-y: auto;
}

.student-option {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background: var(--isabelline);
  border-radius: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.student-option:hover {
  background: #E5E7EB;
}

.student-option-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.student-option-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.student-option-info h6 {
  margin: 0 0 5px 0;
  color: var(--eerie-black-1);
}

.student-option-info p {
  margin: 0;
  color: var(--gray-web);
  font-size: 0.9rem;
}

.bulk-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--eerie-black-1);
}

.form-group textarea {
  padding: 12px 16px;
  border: 2px solid #E5E7EB;
  border-radius: 8px;
  font-size: 1rem;
  resize: vertical;
}

.student-progress {
  padding: 20px 0;
}

.student-header {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 2px solid var(--isabelline);
}

.progress-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
}

.student-header h4 {
  font-size: 1.5rem;
  color: var(--eerie-black-1);
  margin-bottom: 5px;
}

.student-header p {
  color: var(--gray-web);
  margin-bottom: 10px;
}

.enrollment-date {
  background: var(--kappel);
  color: white;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
}

.progress-overview {
  margin-bottom: 30px;
}

.progress-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 20px;
}

.progress-stat {
  background: var(--isabelline);
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}

.progress-stat .label {
  display: block;
  color: var(--gray-web);
  font-size: 0.9rem;
  margin-bottom: 8px;
}

.progress-stat .value {
  display: block;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--kappel);
}

.chapter-progress h5 {
  font-size: 1.2rem;
  color: var(--eerie-black-1);
  margin-bottom: 20px;
}

.progress-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.progress-item {
  background: var(--isabelline);
  padding: 20px;
  border-radius: 10px;
}

.progress-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.progress-info h6 {
  margin: 0;
  color: var(--eerie-black-1);
}

.progress-text {
  color: var(--kappel);
  font-size: 0.9rem;
  font-weight: 600;
}

.progress-bar {
  width: 100%;
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

.modal-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 25px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .section-header {
    flex-direction: column;
    align-items: stretch;
  }
  
  .header-controls {
    flex-direction: column;
    align-items: stretch;
  }
  
  .search-box input {
    width: 100%;
  }
  
  .student-meta {
    flex-direction: column;
    gap: 10px;
  }
  
  .student-actions {
    flex-direction: column;
  }
  
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .progress-stats {
    grid-template-columns: 1fr;
  }
}
</style>


