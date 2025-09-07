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
            <h1 class="page-title">Manage Chapters</h1>
            <p class="course-title">{{ course.title }}</p>
            <p class="course-description">{{ course.description }}</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-primary" @click="showCreateChapter = true">
              <ion-icon name="add-outline"></ion-icon>
              <span>Add New Chapter</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Chapters List -->
    <section class="chapters-section">
      <div class="container">
        <div class="chapters-header">
          <h2>Course Chapters ({{ chapters.length }})</h2>
          <p>Organize your course content into logical chapters</p>
        </div>

        <div class="chapters-list" v-if="chapters.length > 0">
          <div class="chapter-item" v-for="(chapter, index) in chapters" :key="chapter.id">
            <div class="chapter-header">
              <div class="chapter-number">
                <span class="number">{{ index + 1 }}</span>
              </div>
              <div class="chapter-content">
                <h3 class="chapter-title">{{ chapter.title }}</h3>
                <p class="chapter-description">{{ chapter.description }}</p>
                <div class="chapter-meta">
                  <span class="duration">
                    <ion-icon name="time-outline"></ion-icon>
                    {{ chapter.duration }} minutes
                  </span>
                  <span class="lessons-count">
                    <ion-icon name="document-outline"></ion-icon>
                    {{ chapter.lessons_count }} lessons
                  </span>
                  <span class="status" :class="chapter.status">
                    {{ chapter.status }}
                  </span>
                </div>
              </div>
            </div>
            <div class="chapter-actions">
              <button class="btn btn-primary" @click="editChapter(chapter)">
                <ion-icon name="create-outline"></ion-icon>
                <span>Edit</span>
              </button>
              <button class="btn btn-outline" @click="manageLessons(chapter.id)">
                <ion-icon name="document-outline"></ion-icon>
                <span>Lessons</span>
              </button>
              <button class="btn btn-outline" @click="reorderChapter(chapter.id, 'up')" :disabled="index === 0">
                <ion-icon name="arrow-up-outline"></ion-icon>
              </button>
              <button class="btn btn-outline" @click="reorderChapter(chapter.id, 'down')" :disabled="index === chapters.length - 1">
                <ion-icon name="arrow-down-outline"></ion-icon>
              </button>
              <button class="btn btn-danger" @click="deleteChapter(chapter.id)">
                <ion-icon name="trash-outline"></ion-icon>
                <span>Delete</span>
              </button>
            </div>
          </div>
        </div>

        <div class="empty-state" v-else>
          <div class="empty-icon">
            <ion-icon name="document-outline" aria-hidden="true"></ion-icon>
          </div>
          <h3>No chapters yet</h3>
          <p>Start building your course by adding the first chapter</p>
          <button class="btn btn-primary" @click="showCreateChapter = true">
            <ion-icon name="add-outline"></ion-icon>
            <span>Add Your First Chapter</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Create/Edit Chapter Modal -->
    <div class="modal-overlay" v-if="showCreateChapter || editingChapter" @click="closeChapterModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>{{ editingChapter ? 'Edit Chapter' : 'Create New Chapter' }}</h3>
          <button class="close-btn" @click="closeChapterModal">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="saveChapter">
          <div class="form-grid">
            <div class="form-group full-width">
              <label for="chapterTitle">Chapter Title *</label>
              <input type="text" id="chapterTitle" v-model="chapterForm.title" required>
            </div>
            <div class="form-group full-width">
              <label for="chapterDescription">Description *</label>
              <textarea id="chapterDescription" v-model="chapterForm.description" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <label for="chapterDuration">Duration (minutes)</label>
              <input type="number" id="chapterDuration" v-model="chapterForm.duration" min="1">
            </div>
            <div class="form-group">
              <label for="chapterStatus">Status</label>
              <select id="chapterStatus" v-model="chapterForm.status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
              </select>
            </div>
            <div class="form-group full-width">
              <label for="chapterObjectives">Learning Objectives</label>
              <textarea id="chapterObjectives" v-model="chapterForm.objectives" rows="3" placeholder="What will students learn from this chapter?"></textarea>
            </div>
            <div class="form-group full-width">
              <label for="chapterResources">Additional Resources</label>
              <textarea id="chapterResources" v-model="chapterForm.resources" rows="3" placeholder="Links, files, or additional materials"></textarea>
            </div>
          </div>
          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="closeChapterModal">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary" :disabled="savingChapter">
              <span v-if="savingChapter">Saving...</span>
              <span v-else>{{ editingChapter ? 'Update Chapter' : 'Create Chapter' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Chapter Preview Modal -->
    <div class="modal-overlay" v-if="showChapterPreview" @click="showChapterPreview = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Chapter Preview</h3>
          <button class="close-btn" @click="showChapterPreview = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="chapter-preview">
          <div class="preview-header">
            <h2>{{ previewChapter.title }}</h2>
            <div class="preview-meta">
              <span class="duration">{{ previewChapter.duration }} minutes</span>
              <span class="status" :class="previewChapter.status">{{ previewChapter.status }}</span>
            </div>
          </div>
          <div class="preview-content">
            <div class="description-section">
              <h4>Description</h4>
              <p>{{ previewChapter.description }}</p>
            </div>
            <div class="objectives-section" v-if="previewChapter.objectives">
              <h4>Learning Objectives</h4>
              <p>{{ previewChapter.objectives }}</p>
            </div>
            <div class="resources-section" v-if="previewChapter.resources">
              <h4>Additional Resources</h4>
              <p>{{ previewChapter.resources }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'CourseChapters',
  data() {
    return {
      course: {
        id: null,
        title: '',
        description: ''
      },
      chapters: [],
      showCreateChapter: false,
      editingChapter: null,
      showChapterPreview: false,
      previewChapter: {},
      savingChapter: false,
      chapterForm: {
        title: '',
        description: '',
        duration: 30,
        status: 'draft',
        objectives: '',
        resources: ''
      }
    }
  },
  mounted() {
    this.loadCourseData();
    this.loadChapters();
  },
  methods: {
    async loadCourseData() {
      try {
        const courseId = this.$route.params.courseId;
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
        } else {
          this.$router.push('/instructor/dashboard');
        }
      } catch (error) {
        console.error('Error loading course data:', error);
        this.$router.push('/instructor/dashboard');
      }
    },

    async loadChapters() {
      try {
        const courseId = this.$route.params.courseId;
        const token = localStorage.getItem('token');
        
        const response = await fetch(`/api/instructor/courses/${courseId}/chapters`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.chapters = data.chapters || [];
        }
      } catch (error) {
        console.error('Error loading chapters:', error);
      }
    },

    editChapter(chapter) {
      this.editingChapter = chapter;
      this.chapterForm = {
        title: chapter.title,
        description: chapter.description,
        duration: chapter.duration || 30,
        status: chapter.status || 'draft',
        objectives: chapter.objectives || '',
        resources: chapter.resources || ''
      };
    },

    closeChapterModal() {
      this.showCreateChapter = false;
      this.editingChapter = null;
      this.resetChapterForm();
    },

    resetChapterForm() {
      this.chapterForm = {
        title: '',
        description: '',
        duration: 30,
        status: 'draft',
        objectives: '',
        resources: ''
      };
    },

    async saveChapter() {
      this.savingChapter = true;
      
      try {
        const courseId = this.$route.params.courseId;
        const token = localStorage.getItem('token');
        const method = this.editingChapter ? 'PUT' : 'POST';
        const url = this.editingChapter 
          ? `/api/instructor/chapters/${this.editingChapter.id}`
          : `/api/instructor/courses/${courseId}/chapters`;

        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(this.chapterForm)
        });

        const data = await response.json();

        if (response.ok && data.success) {
          const message = this.editingChapter ? 'Chapter updated successfully!' : 'Chapter created successfully!';
          alert(message);
          this.closeChapterModal();
          this.loadChapters();
        } else {
          alert(data.message || 'Failed to save chapter');
        }
      } catch (error) {
        console.error('Error saving chapter:', error);
        alert('An error occurred while saving the chapter');
      } finally {
        this.savingChapter = false;
      }
    },

    async deleteChapter(chapterId) {
      if (!confirm('Are you sure you want to delete this chapter? This action cannot be undone.')) {
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/chapters/${chapterId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          alert('Chapter deleted successfully!');
          this.loadChapters();
        } else {
          alert('Failed to delete chapter');
        }
      } catch (error) {
        console.error('Error deleting chapter:', error);
        alert('An error occurred while deleting the chapter');
      }
    },

    async reorderChapter(chapterId, direction) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/chapters/${chapterId}/reorder`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({ direction })
        });

        if (response.ok) {
          this.loadChapters();
        }
      } catch (error) {
        console.error('Error reordering chapter:', error);
      }
    },

    previewChapter(chapter) {
      this.previewChapter = chapter;
      this.showChapterPreview = true;
    },

    manageLessons(chapterId) {
      this.$router.push(`/instructor/chapters/${chapterId}/lessons`);
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

.chapters-section {
  padding: 60px 0;
  background: var(--isabelline);
}

.chapters-header {
  text-align: center;
  margin-bottom: 40px;
}

.chapters-header h2 {
  font-size: 2rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.chapters-header p {
  color: var(--gray-web);
  font-size: 1.1rem;
}

.chapters-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.chapter-item {
  background: white;
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.chapter-item:hover {
  transform: translateY(-2px);
}

.chapter-header {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.chapter-number {
  flex-shrink: 0;
}

.chapter-number .number {
  width: 50px;
  height: 50px;
  background: var(--kappel);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  font-weight: 700;
}

.chapter-content {
  flex: 1;
}

.chapter-title {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
}

.chapter-description {
  color: var(--gray-web);
  margin-bottom: 15px;
  line-height: 1.5;
}

.chapter-meta {
  display: flex;
  gap: 20px;
  font-size: 0.9rem;
  color: var(--kappel);
}

.chapter-meta span {
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

.status.published {
  background: #10B981;
  color: white;
}

.status.draft {
  background: #F59E0B;
  color: white;
}

.status.archived {
  background: #6B7280;
  color: white;
}

.chapter-actions {
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

.modal-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 25px;
}

.chapter-preview {
  padding: 20px 0;
}

.preview-header {
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 2px solid var(--isabelline);
}

.preview-header h2 {
  font-size: 1.8rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.preview-meta {
  display: flex;
  gap: 20px;
  font-size: 1rem;
  color: var(--kappel);
}

.preview-content {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.preview-content h4 {
  font-size: 1.2rem;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
}

.preview-content p {
  color: var(--gray-web);
  line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
  }
  
  .chapter-actions {
    flex-direction: column;
  }
  
  .chapter-meta {
    flex-direction: column;
    gap: 10px;
  }
}
</style>


