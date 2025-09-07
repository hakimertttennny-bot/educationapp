<template>
  <main>
    <!-- Header -->
    <section class="page-header">
      <div class="container">
        <div class="header-content">
          <div class="back-button">
            <button class="btn btn-outline" @click="$router.go(-1)">
              <ion-icon name="arrow-back-outline"></ion-icon>
              <span>Back to Chapters</span>
            </button>
          </div>
          <div class="lesson-info">
            <h1 class="page-title">Manage Lessons</h1>
            <p class="chapter-title">{{ chapter.title }}</p>
            <p class="course-title">{{ course.title }}</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-primary" @click="showCreateLesson = true">
              <ion-icon name="add-outline"></ion-icon>
              <span>Add New Lesson</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Lessons List -->
    <section class="lessons-section">
      <div class="container">
        <div class="lessons-header">
          <h2>Chapter Lessons ({{ lessons.length }})</h2>
          <p>Create engaging lessons with various content types</p>
        </div>

        <div class="lessons-list" v-if="lessons.length > 0">
          <div class="lesson-item" v-for="(lesson, index) in lessons" :key="lesson.id">
            <div class="lesson-header">
              <div class="lesson-number">
                <span class="number">{{ index + 1 }}</span>
              </div>
              <div class="lesson-content">
                <h3 class="lesson-title">{{ lesson.title }}</h3>
                <p class="lesson-description">{{ lesson.description }}</p>
                <div class="lesson-meta">
                  <span class="type">
                    <ion-icon name="document-outline"></ion-icon>
                    {{ lesson.type }}
                  </span>
                  <span class="duration">
                    <ion-icon name="time-outline"></ion-icon>
                    {{ lesson.duration }} minutes
                  </span>
                  <span class="status" :class="lesson.status">
                    {{ lesson.status }}
                  </span>
                </div>
                <div class="lesson-content-preview" v-if="lesson.content">
                  <div class="content-type-indicator">
                    <ion-icon :name="getContentIcon(lesson.type)"></ion-icon>
                    <span>{{ getContentTypeLabel(lesson.type) }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="lesson-actions">
              <button class="btn btn-primary" @click="editLesson(lesson)">
                <ion-icon name="create-outline"></ion-icon>
                <span>Edit</span>
              </button>
              <button class="btn btn-outline" @click="previewLesson(lesson)">
                <ion-icon name="eye-outline"></ion-icon>
                <span>Preview</span>
              </button>
              <button class="btn btn-outline" @click="reorderLesson(lesson.id, 'up')" :disabled="index === 0">
                <ion-icon name="arrow-up-outline"></ion-icon>
              </button>
              <button class="btn btn-outline" @click="reorderLesson(lesson.id, 'down')" :disabled="index === lessons.length - 1">
                <ion-icon name="arrow-down-outline"></ion-icon>
              </button>
              <button class="btn btn-danger" @click="deleteLesson(lesson.id)">
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
          <h3>No lessons yet</h3>
          <p>Start building your chapter by adding the first lesson</p>
          <button class="btn btn-primary" @click="showCreateLesson = true">
            <ion-icon name="add-outline"></ion-icon>
            <span>Add Your First Lesson</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Create/Edit Lesson Modal -->
    <div class="modal-overlay" v-if="showCreateLesson || editingLesson" @click="closeLessonModal">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>{{ editingLesson ? 'Edit Lesson' : 'Create New Lesson' }}</h3>
          <button class="close-btn" @click="closeLessonModal">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <form @submit.prevent="saveLesson">
          <div class="form-grid">
            <div class="form-group full-width">
              <label for="lessonTitle">Lesson Title *</label>
              <input type="text" id="lessonTitle" v-model="lessonForm.title" required>
            </div>
            <div class="form-group full-width">
              <label for="lessonDescription">Description *</label>
              <textarea id="lessonDescription" v-model="lessonForm.description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="lessonType">Content Type *</label>
              <select id="lessonType" v-model="lessonForm.type" required @change="onTypeChange">
                <option value="">Select Type</option>
                <option value="video">Video</option>
                <option value="text">Text/Article</option>
                <option value="quiz">Quiz</option>
                <option value="assignment">Assignment</option>
                <option value="file">File Download</option>
                <option value="link">External Link</option>
              </select>
            </div>
            <div class="form-group">
              <label for="lessonDuration">Duration (minutes)</label>
              <input type="number" id="lessonDuration" v-model="lessonForm.duration" min="1">
            </div>
            <div class="form-group">
              <label for="lessonStatus">Status</label>
              <select id="lessonStatus" v-model="lessonForm.status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
              </select>
            </div>
            <div class="form-group full-width">
              <label for="lessonObjectives">Learning Objectives</label>
              <textarea id="lessonObjectives" v-model="lessonForm.objectives" rows="3" placeholder="What will students learn from this lesson?"></textarea>
            </div>
          </div>

          <!-- Dynamic Content Fields Based on Type -->
          <div class="content-fields" v-if="lessonForm.type">
            <h4>Content Details</h4>
            
            <!-- Video Content -->
            <div v-if="lessonForm.type === 'video'" class="content-type-fields">
              <div class="form-group full-width">
                <label for="videoUrl">Video URL *</label>
                <input type="url" id="videoUrl" v-model="lessonForm.content.video_url" placeholder="YouTube, Vimeo, or direct video URL">
              </div>
              <div class="form-group">
                <label for="videoThumbnail">Thumbnail Image</label>
                <input type="file" id="videoThumbnail" @change="handleVideoThumbnail" accept="image/*">
              </div>
              <div class="form-group">
                <label for="videoTranscript">Transcript</label>
                <textarea id="videoTranscript" v-model="lessonForm.content.transcript" rows="4" placeholder="Video transcript or subtitles"></textarea>
              </div>
            </div>

            <!-- Text Content -->
            <div v-if="lessonForm.type === 'text'" class="content-type-fields">
              <div class="form-group full-width">
                <label for="textContent">Content *</label>
                <textarea id="textContent" v-model="lessonForm.content.text_content" rows="8" placeholder="Write your lesson content here..."></textarea>
              </div>
              <div class="form-group full-width">
                <label for="textResources">Additional Resources</label>
                <textarea id="textResources" v-model="lessonForm.content.resources" rows="3" placeholder="Links, references, or additional materials"></textarea>
              </div>
            </div>

            <!-- Quiz Content -->
            <div v-if="lessonForm.type === 'quiz'" class="content-type-fields">
              <div class="form-group full-width">
                <label for="quizQuestions">Quiz Questions</label>
                <div class="quiz-questions">
                  <div v-for="(question, qIndex) in lessonForm.content.questions" :key="qIndex" class="question-item">
                    <div class="question-header">
                      <h5>Question {{ qIndex + 1 }}</h5>
                      <button type="button" class="btn btn-danger btn-sm" @click="removeQuestion(qIndex)">
                        <ion-icon name="trash-outline"></ion-icon>
                      </button>
                    </div>
                    <input type="text" v-model="question.text" placeholder="Question text" class="question-text">
                    <div class="answers">
                      <div v-for="(answer, aIndex) in question.answers" :key="aIndex" class="answer-item">
                        <input type="radio" :name="`question_${qIndex}`" :value="aIndex" v-model="question.correct_answer">
                        <input type="text" v-model="answer.text" placeholder="Answer option">
                        <button type="button" class="btn btn-danger btn-sm" @click="removeAnswer(qIndex, aIndex)">
                          <ion-icon name="close-outline"></ion-icon>
                        </button>
                      </div>
                      <button type="button" class="btn btn-outline btn-sm" @click="addAnswer(qIndex)">
                        <ion-icon name="add-outline"></ion-icon>
                        Add Answer
                      </button>
                    </div>
                  </div>
                  <button type="button" class="btn btn-outline" @click="addQuestion">
                    <ion-icon name="add-outline"></ion-icon>
                    Add Question
                  </button>
                </div>
              </div>
            </div>

            <!-- Assignment Content -->
            <div v-if="lessonForm.type === 'assignment'" class="content-type-fields">
              <div class="form-group full-width">
                <label for="assignmentDescription">Assignment Description *</label>
                <textarea id="assignmentDescription" v-model="lessonForm.content.description" rows="4" placeholder="Describe the assignment requirements"></textarea>
              </div>
              <div class="form-group">
                <label for="assignmentDueDate">Due Date</label>
                <input type="date" id="assignmentDueDate" v-model="lessonForm.content.due_date">
              </div>
              <div class="form-group">
                <label for="assignmentPoints">Points</label>
                <input type="number" id="assignmentPoints" v-model="lessonForm.content.points" min="1">
              </div>
              <div class="form-group full-width">
                <label for="assignmentFiles">Assignment Files</label>
                <input type="file" id="assignmentFiles" @change="handleAssignmentFiles" multiple>
              </div>
            </div>

            <!-- File Content -->
            <div v-if="lessonForm.type === 'file'" class="content-type-fields">
              <div class="form-group full-width">
                <label for="fileUpload">File Upload *</label>
                <input type="file" id="fileUpload" @change="handleFileUpload" multiple>
              </div>
              <div class="form-group full-width">
                <label for="fileDescription">File Description</label>
                <textarea id="fileDescription" v-model="lessonForm.content.description" rows="3" placeholder="Describe what these files contain"></textarea>
              </div>
            </div>

            <!-- Link Content -->
            <div v-if="lessonForm.type === 'link'" class="content-type-fields">
              <div class="form-group full-width">
                <label for="linkUrl">External URL *</label>
                <input type="url" id="linkUrl" v-model="lessonForm.content.url" placeholder="https://example.com">
              </div>
              <div class="form-group full-width">
                <label for="linkDescription">Link Description</label>
                <textarea id="linkDescription" v-model="lessonForm.content.description" rows="3" placeholder="Describe what this link contains"></textarea>
              </div>
            </div>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn btn-outline" @click="closeLessonModal">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary" :disabled="savingLesson">
              <span v-if="savingLesson">Saving...</span>
              <span v-else>{{ editingLesson ? 'Update Lesson' : 'Create Lesson' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Lesson Preview Modal -->
    <div class="modal-overlay" v-if="showLessonPreview" @click="showLessonPreview = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Lesson Preview</h3>
          <button class="close-btn" @click="showLessonPreview = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="lesson-preview">
          <div class="preview-header">
            <h2>{{ previewLesson.title }}</h2>
            <div class="preview-meta">
              <span class="type">{{ previewLesson.type }}</span>
              <span class="duration">{{ previewLesson.duration }} minutes</span>
              <span class="status" :class="previewLesson.status">{{ previewLesson.status }}</span>
            </div>
          </div>
          <div class="preview-content">
            <div class="description-section">
              <h4>Description</h4>
              <p>{{ previewLesson.description }}</p>
            </div>
            <div class="objectives-section" v-if="previewLesson.objectives">
              <h4>Learning Objectives</h4>
              <p>{{ previewLesson.objectives }}</p>
            </div>
            <div class="content-preview-section">
              <h4>Content Preview</h4>
              <div class="content-preview" v-if="previewLesson.content">
                <div v-if="previewLesson.type === 'video'">
                  <div class="video-preview">
                    <div class="video-placeholder">
                      <ion-icon name="play-circle-outline"></ion-icon>
                      <p>Video: {{ previewLesson.content.video_url }}</p>
                    </div>
                  </div>
                </div>
                <div v-else-if="previewLesson.type === 'text'">
                  <div class="text-preview">
                    <p>{{ previewLesson.content.text_content }}</p>
                  </div>
                </div>
                <div v-else-if="previewLesson.type === 'quiz'">
                  <div class="quiz-preview">
                    <p>Quiz with {{ previewLesson.content.questions?.length || 0 }} questions</p>
                  </div>
                </div>
                <div v-else-if="previewLesson.type === 'assignment'">
                  <div class="assignment-preview">
                    <p>{{ previewLesson.content.description }}</p>
                    <p><strong>Due Date:</strong> {{ previewLesson.content.due_date }}</p>
                    <p><strong>Points:</strong> {{ previewLesson.content.points }}</p>
                  </div>
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
  name: 'ChapterLessons',
  data() {
    return {
      course: {
        id: null,
        title: ''
      },
      chapter: {
        id: null,
        title: ''
      },
      lessons: [],
      showCreateLesson: false,
      editingLesson: null,
      showLessonPreview: false,
      previewLesson: {},
      savingLesson: false,
      lessonForm: {
        title: '',
        description: '',
        type: '',
        duration: 30,
        status: 'draft',
        objectives: '',
        content: {}
      }
    }
  },
  mounted() {
    this.loadData();
  },
  methods: {
    async loadData() {
      const chapterId = this.$route.params.chapterId;
      await this.loadChapterData(chapterId);
      await this.loadLessons(chapterId);
    },

    async loadChapterData(chapterId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/chapters/${chapterId}`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.chapter = data.chapter;
          this.course = data.course;
        }
      } catch (error) {
        console.error('Error loading chapter data:', error);
      }
    },

    async loadLessons(chapterId) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/chapters/${chapterId}/lessons`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.lessons = data.lessons || [];
        }
      } catch (error) {
        console.error('Error loading lessons:', error);
      }
    },

    onTypeChange() {
      // Reset content based on new type
      this.lessonForm.content = {};
      
      if (this.lessonForm.type === 'quiz') {
        this.lessonForm.content = {
          questions: []
        };
        this.addQuestion();
      } else if (this.lessonForm.type === 'assignment') {
        this.lessonForm.content = {
          description: '',
          due_date: '',
          points: 10,
          files: []
        };
      }
    },

    addQuestion() {
      if (!this.lessonForm.content.questions) {
        this.lessonForm.content.questions = [];
      }
      this.lessonForm.content.questions.push({
        text: '',
        answers: [
          { text: '', correct: false },
          { text: '', correct: false }
        ],
        correct_answer: 0
      });
    },

    removeQuestion(index) {
      this.lessonForm.content.questions.splice(index, 1);
    },

    addAnswer(questionIndex) {
      this.lessonForm.content.questions[questionIndex].answers.push({
        text: '',
        correct: false
      });
    },

    removeAnswer(questionIndex, answerIndex) {
      this.lessonForm.content.questions[questionIndex].answers.splice(answerIndex, 1);
    },

    editLesson(lesson) {
      this.editingLesson = lesson;
      this.lessonForm = {
        title: lesson.title,
        description: lesson.description,
        type: lesson.type,
        duration: lesson.duration || 30,
        status: lesson.status || 'draft',
        objectives: lesson.objectives || '',
        content: lesson.content || {}
      };
    },

    closeLessonModal() {
      this.showCreateLesson = false;
      this.editingLesson = null;
      this.resetLessonForm();
    },

    resetLessonForm() {
      this.lessonForm = {
        title: '',
        description: '',
        type: '',
        duration: 30,
        status: 'draft',
        objectives: '',
        content: {}
      };
    },

    async saveLesson() {
      this.savingLesson = true;
      
      try {
        const chapterId = this.$route.params.chapterId;
        const token = localStorage.getItem('token');
        const method = this.editingLesson ? 'PUT' : 'POST';
        const url = this.editingLesson 
          ? `/api/instructor/lessons/${this.editingLesson.id}`
          : `/api/instructor/chapters/${chapterId}/lessons`;

        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(this.lessonForm)
        });

        const data = await response.json();

        if (response.ok && data.success) {
          const message = this.editingLesson ? 'Lesson updated successfully!' : 'Lesson created successfully!';
          alert(message);
          this.closeLessonModal();
          this.loadLessons(chapterId);
        } else {
          alert(data.message || 'Failed to save lesson');
        }
      } catch (error) {
        console.error('Error saving lesson:', error);
        alert('An error occurred while saving the lesson');
      } finally {
        this.savingLesson = false;
      }
    },

    async deleteLesson(lessonId) {
      if (!confirm('Are you sure you want to delete this lesson? This action cannot be undone.')) {
        return;
      }

      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/lessons/${lessonId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          alert('Lesson deleted successfully!');
          this.loadLessons(this.$route.params.chapterId);
        } else {
          alert('Failed to delete lesson');
        }
      } catch (error) {
        console.error('Error deleting lesson:', error);
        alert('An error occurred while deleting the lesson');
      }
    },

    async reorderLesson(lessonId, direction) {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/lessons/${lessonId}/reorder`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({ direction })
        });

        if (response.ok) {
          this.loadLessons(this.$route.params.chapterId);
        }
      } catch (error) {
        console.error('Error reordering lesson:', error);
      }
    },

    previewLesson(lesson) {
      this.previewLesson = lesson;
      this.showLessonPreview = true;
    },

    getContentIcon(type) {
      const icons = {
        video: 'play-circle-outline',
        text: 'document-text-outline',
        quiz: 'help-circle-outline',
        assignment: 'clipboard-outline',
        file: 'download-outline',
        link: 'link-outline'
      };
      return icons[type] || 'document-outline';
    },

    getContentTypeLabel(type) {
      const labels = {
        video: 'Video Lesson',
        text: 'Text Article',
        quiz: 'Interactive Quiz',
        assignment: 'Assignment',
        file: 'File Download',
        link: 'External Resource'
      };
      return labels[type] || 'Lesson';
    },

    handleVideoThumbnail(event) {
      const file = event.target.files[0];
      if (file) {
        this.lessonForm.content.thumbnail = file;
      }
    },

    handleAssignmentFiles(event) {
      const files = Array.from(event.target.files);
      this.lessonForm.content.files = files;
    },

    handleFileUpload(event) {
      const files = Array.from(event.target.files);
      this.lessonForm.content.uploaded_files = files;
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

.lesson-info {
  flex: 1;
}

.page-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.chapter-title {
  font-size: 1.3rem;
  font-weight: 600;
  margin-bottom: 5px;
  opacity: 0.9;
}

.course-title {
  font-size: 1rem;
  opacity: 0.8;
}

.header-actions {
  flex-shrink: 0;
}

.lessons-section {
  padding: 60px 0;
  background: var(--isabelline);
}

.lessons-header {
  text-align: center;
  margin-bottom: 40px;
}

.lessons-header h2 {
  font-size: 2rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.lessons-header p {
  color: var(--gray-web);
  font-size: 1.1rem;
}

.lessons-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.lesson-item {
  background: white;
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.lesson-item:hover {
  transform: translateY(-2px);
}

.lesson-header {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.lesson-number {
  flex-shrink: 0;
}

.lesson-number .number {
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

.lesson-content {
  flex: 1;
}

.lesson-title {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
}

.lesson-description {
  color: var(--gray-web);
  margin-bottom: 15px;
  line-height: 1.5;
}

.lesson-meta {
  display: flex;
  gap: 20px;
  font-size: 0.9rem;
  color: var(--kappel);
  margin-bottom: 15px;
}

.lesson-meta span {
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

.content-type-indicator {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background: var(--isabelline);
  border-radius: 8px;
  font-size: 0.9rem;
  color: var(--kappel);
}

.lesson-actions {
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
  max-width: 900px;
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

.content-fields {
  margin-top: 30px;
  padding-top: 30px;
  border-top: 2px solid var(--isabelline);
}

.content-fields h4 {
  font-size: 1.2rem;
  color: var(--eerie-black-1);
  margin-bottom: 20px;
}

.content-type-fields {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.quiz-questions {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.question-item {
  background: var(--isabelline);
  padding: 20px;
  border-radius: 10px;
}

.question-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.question-header h5 {
  margin: 0;
  color: var(--eerie-black-1);
}

.question-text {
  margin-bottom: 15px;
}

.answers {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.answer-item {
  display: flex;
  align-items: center;
  gap: 10px;
}

.answer-item input[type="radio"] {
  margin: 0;
}

.answer-item input[type="text"] {
  flex: 1;
}

.modal-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 25px;
}

.lesson-preview {
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

.content-preview {
  background: var(--isabelline);
  padding: 20px;
  border-radius: 10px;
}

.video-placeholder {
  text-align: center;
  padding: 40px;
  background: white;
  border-radius: 8px;
  border: 2px dashed var(--kappel);
}

.video-placeholder ion-icon {
  font-size: 3rem;
  color: var(--kappel);
  margin-bottom: 15px;
}

.text-preview {
  background: white;
  padding: 20px;
  border-radius: 8px;
  border-left: 4px solid var(--kappel);
}

.quiz-preview,
.assignment-preview {
  background: white;
  padding: 20px;
  border-radius: 8px;
  border-left: 4px solid var(--kappel);
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
  
  .lesson-actions {
    flex-direction: column;
  }
  
  .lesson-meta {
    flex-direction: column;
    gap: 10px;
  }
}
</style>


