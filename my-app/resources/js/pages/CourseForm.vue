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
          <div class="page-info">
            <h1 class="page-title">{{ isEditing ? 'Edit Course' : 'Create New Course' }}</h1>
            <p class="page-description">{{ isEditing ? 'Update your course information and content' : 'Build an engaging course for your students' }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Course Form -->
    <section class="course-form-section">
      <div class="container">
        <form @submit.prevent="saveCourse" class="course-form">
          <div class="form-grid">
            <!-- Basic Information -->
            <div class="form-section">
              <h3 class="section-title">
                <ion-icon name="information-circle-outline"></ion-icon>
                Basic Information
              </h3>
              
              <div class="form-group full-width">
                <label for="courseTitle">Course Title *</label>
                <input 
                  type="text" 
                  id="courseTitle" 
                  v-model="courseForm.title" 
                  placeholder="Enter course title"
                  required
                >
              </div>

              <div class="form-group full-width">
                <label for="courseDescription">Course Description *</label>
                <textarea 
                  id="courseDescription" 
                  v-model="courseForm.description" 
                  rows="4" 
                  placeholder="Describe what students will learn from this course"
                  required
                ></textarea>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="courseCategory">Category *</label>
                  <select id="courseCategory" v-model="courseForm.category_id" required>
                    <option value="">Select Category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="courseLevel">Difficulty Level *</label>
                  <select id="courseLevel" v-model="courseForm.level" required>
                    <option value="">Select Level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="coursePrice">Price ($) *</label>
                  <input 
                    type="number" 
                    id="coursePrice" 
                    v-model="courseForm.price" 
                    min="0" 
                    step="0.01"
                    placeholder="0.00"
                    required
                  >
                </div>

                <div class="form-group">
                  <label for="courseDuration">Estimated Duration (hours)</label>
                  <input 
                    type="number" 
                    id="courseDuration" 
                    v-model="courseForm.duration" 
                    min="1"
                    placeholder="10"
                  >
                </div>
              </div>
            </div>

            <!-- Course Image -->
            <div class="form-section">
              <h3 class="section-title">
                <ion-icon name="image-outline"></ion-icon>
                Course Image
              </h3>
              
              <div class="image-upload-area">
                <div class="current-image" v-if="courseForm.image || imagePreview">
                  <img :src="imagePreview || getImageUrl(courseForm.image)" :alt="courseForm.title">
                  <div class="image-overlay">
                    <button type="button" class="btn btn-outline btn-sm" @click="changeImage">
                      <ion-icon name="camera-outline"></ion-icon>
                      Change Image
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" @click="removeImage" v-if="courseForm.image">
                      <ion-icon name="trash-outline"></ion-icon>
                      Remove
                    </button>
                  </div>
                </div>
                
                <div class="upload-placeholder" v-else @click="triggerImageUpload">
                  <ion-icon name="add-circle-outline"></ion-icon>
                  <p>Click to upload course image</p>
                  <span class="upload-hint">Recommended: 800x600px, JPG/PNG</span>
                </div>
                
                <input 
                  type="file" 
                  ref="imageInput" 
                  @change="handleImageUpload" 
                  accept="image/*" 
                  style="display: none"
                >
              </div>
            </div>

            <!-- Course Content -->
            <div class="form-section full-width">
              <h3 class="section-title">
                <ion-icon name="document-text-outline"></ion-icon>
                Course Content
              </h3>
              
              <div class="form-group">
                <label for="courseObjectives">Learning Objectives</label>
                <textarea 
                  id="courseObjectives" 
                  v-model="courseForm.objectives" 
                  rows="4" 
                  placeholder="What will students be able to do after completing this course?"
                ></textarea>
              </div>

              <div class="form-group">
                <label for="coursePrerequisites">Prerequisites</label>
                <textarea 
                  id="coursePrerequisites" 
                  v-model="courseForm.prerequisites" 
                  rows="3" 
                  placeholder="What should students know before taking this course?"
                ></textarea>
              </div>

              <div class="form-group">
                <label for="courseTargetAudience">Target Audience</label>
                <textarea 
                  id="courseTargetAudience" 
                  v-model="courseForm.target_audience" 
                  rows="3" 
                  placeholder="Who is this course designed for?"
                ></textarea>
              </div>
            </div>

            <!-- Course Settings -->
            <div class="form-section full-width">
              <h3 class="section-title">
                <ion-icon name="settings-outline"></ion-icon>
                Course Settings
              </h3>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="courseStatus">Status</label>
                  <select id="courseStatus" v-model="courseForm.status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="courseLanguage">Language</label>
                  <select id="courseLanguage" v-model="courseForm.language">
                    <option value="en">English</option>
                    <option value="fr">French</option>
                    <option value="es">Spanish</option>
                    <option value="de">German</option>
                    <option value="it">Italian</option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="courseMaxStudents">Maximum Students</label>
                  <input 
                    type="number" 
                    id="courseMaxStudents" 
                    v-model="courseForm.max_students" 
                    min="1"
                    placeholder="Unlimited"
                  >
                </div>

                <div class="form-group">
                  <label for="courseStartDate">Start Date</label>
                  <input 
                    type="date" 
                    id="courseStartDate" 
                    v-model="courseForm.start_date"
                  >
                </div>
              </div>

              <div class="form-group">
                <label class="checkbox-label">
                  <input type="checkbox" v-model="courseForm.is_featured">
                  <span class="checkmark"></span>
                  Feature this course on the homepage
                </label>
              </div>

              <div class="form-group">
                <label class="checkbox-label">
                  <input type="checkbox" v-model="courseForm.allow_enrollment">
                  <span class="checkmark"></span>
                  Allow students to enroll in this course
                </label>
              </div>
            </div>

            <!-- SEO & Marketing -->
            <div class="form-section full-width">
              <h3 class="section-title">
                <ion-icon name="trending-up-outline"></ion-icon>
                SEO & Marketing
              </h3>
              
              <div class="form-group">
                <label for="courseMetaTitle">Meta Title</label>
                <input 
                  type="text" 
                  id="courseMetaTitle" 
                  v-model="courseForm.meta_title" 
                  placeholder="SEO-friendly title for search engines"
                >
                <small class="form-hint">Leave empty to use course title</small>
              </div>

              <div class="form-group">
                <label for="courseMetaDescription">Meta Description</label>
                <textarea 
                  id="courseMetaDescription" 
                  v-model="courseForm.meta_description" 
                  rows="3" 
                  placeholder="Brief description for search engine results"
                ></textarea>
                <small class="form-hint">Leave empty to use course description</small>
              </div>

              <div class="form-group">
                <label for="courseKeywords">Keywords</label>
                <input 
                  type="text" 
                  id="courseKeywords" 
                  v-model="courseForm.keywords" 
                  placeholder="comma, separated, keywords"
                >
                <small class="form-hint">Separate keywords with commas</small>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="form-actions">
            <button type="button" class="btn btn-outline" @click="$router.go(-1)">
              Cancel
            </button>
            <button type="button" class="btn btn-outline" @click="saveAsDraft" :disabled="saving">
              Save as Draft
            </button>
            <button type="submit" class="btn btn-primary" :disabled="saving">
              <span v-if="saving">Saving...</span>
              <span v-else>{{ isEditing ? 'Update Course' : 'Create Course' }}</span>
            </button>
          </div>
        </form>
      </div>
    </section>

    <!-- Course Preview Modal -->
    <div class="modal-overlay" v-if="showPreview" @click="showPreview = false">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>Course Preview</h3>
          <button class="close-btn" @click="showPreview = false">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>
        <div class="course-preview">
          <div class="preview-header">
            <div class="preview-image">
              <img :src="imagePreview || getImageUrl(courseForm.image) || '/images/course-placeholder.jpg'" :alt="courseForm.title">
            </div>
            <div class="preview-info">
              <h2>{{ courseForm.title || 'Course Title' }}</h2>
              <p class="preview-description">{{ courseForm.description || 'Course description will appear here' }}</p>
              <div class="preview-meta">
                <span class="level" v-if="courseForm.level">{{ courseForm.level }}</span>
                <span class="duration" v-if="courseForm.duration">{{ courseForm.duration }} hours</span>
                <span class="price" v-if="courseForm.price">${{ courseForm.price }}</span>
              </div>
            </div>
          </div>
          
          <div class="preview-content">
            <div class="preview-section" v-if="courseForm.objectives">
              <h4>Learning Objectives</h4>
              <p>{{ courseForm.objectives }}</p>
            </div>
            
            <div class="preview-section" v-if="courseForm.prerequisites">
              <h4>Prerequisites</h4>
              <p>{{ courseForm.prerequisites }}</p>
            </div>
            
            <div class="preview-section" v-if="courseForm.target_audience">
              <h4>Target Audience</h4>
              <p>{{ courseForm.target_audience }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'CourseForm',
  data() {
    return {
      isEditing: false,
      courseId: null,
      categories: [],
      saving: false,
      showPreview: false,
      imagePreview: null,
      courseForm: {
        title: '',
        description: '',
        category_id: '',
        level: '',
        price: '',
        duration: '',
        objectives: '',
        prerequisites: '',
        target_audience: '',
        status: 'draft',
        language: 'en',
        max_students: '',
        start_date: '',
        is_featured: false,
        allow_enrollment: true,
        meta_title: '',
        meta_description: '',
        keywords: ''
      }
    }
  },
  mounted() {
    this.loadData();
  },
  methods: {
    async loadData() {
      await this.loadCategories();
      
      // Check if editing existing course
      if (this.$route.params.courseId) {
        this.isEditing = true;
        this.courseId = this.$route.params.courseId;
        await this.loadCourseData();
      }
    },

    async loadCategories() {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch('/api/categories', {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.categories = data.categories || [];
        }
      } catch (error) {
        console.error('Error loading categories:', error);
      }
    },

    async loadCourseData() {
      try {
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/instructor/courses/${this.courseId}`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.ok) {
          const data = await response.json();
          this.courseForm = { ...data.course };
        }
      } catch (error) {
        console.error('Error loading course data:', error);
      }
    },

    triggerImageUpload() {
      this.$refs.imageInput.click();
    },

    handleImageUpload(event) {
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

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);

        // Store file for upload
        this.courseForm.image_file = file;
      }
    },

    changeImage() {
      this.triggerImageUpload();
    },

    removeImage() {
      this.courseForm.image = null;
      this.courseForm.image_file = null;
      this.imagePreview = null;
    },

    async saveCourse() {
      if (!this.validateForm()) {
        return;
      }

      this.saving = true;
      
      try {
        const token = localStorage.getItem('token');
        const method = this.isEditing ? 'PUT' : 'POST';
        const url = this.isEditing 
          ? `/api/instructor/courses/${this.courseId}`
          : '/api/instructor/courses';

        // Prepare form data for file upload
        const formData = new FormData();
        
        // Add all form fields
        Object.keys(this.courseForm).forEach(key => {
          if (key === 'image_file' && this.courseForm[key]) {
            formData.append('image', this.courseForm[key]);
          } else if (key !== 'image_file') {
            formData.append(key, this.courseForm[key]);
          }
        });

        const response = await fetch(url, {
          method: method,
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
          const message = this.isEditing ? 'Course updated successfully!' : 'Course created successfully!';
          alert(message);
          
          if (!this.isEditing) {
            // Redirect to course chapters page for new course
            this.$router.push(`/instructor/courses/${data.course.id}/chapters`);
          } else {
            // Go back to dashboard
            this.$router.go(-1);
          }
        } else {
          alert(data.message || 'Failed to save course');
        }
      } catch (error) {
        console.error('Error saving course:', error);
        alert('An error occurred while saving the course');
      } finally {
        this.saving = false;
      }
    },

    async saveAsDraft() {
      this.courseForm.status = 'draft';
      await this.saveCourse();
    },

    validateForm() {
      if (!this.courseForm.title.trim()) {
        alert('Please enter a course title');
        return false;
      }

      if (!this.courseForm.description.trim()) {
        alert('Please enter a course description');
        return false;
      }

      if (!this.courseForm.category_id) {
        alert('Please select a category');
        return false;
      }

      if (!this.courseForm.level) {
        alert('Please select a difficulty level');
        return false;
      }

      if (!this.courseForm.price || this.courseForm.price < 0) {
        alert('Please enter a valid price');
        return false;
      }

      return true;
    },

    getImageUrl(avatarPath) {
      if (!avatarPath) {
        return null;
      }
      
      if (avatarPath.startsWith('http')) {
        return avatarPath;
      }
      
      return `/storage/${avatarPath}`;
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

.page-info {
  flex: 1;
}

.page-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.page-description {
  font-size: 1.1rem;
  opacity: 0.9;
}

.course-form-section {
  padding: 60px 0;
  background: var(--isabelline);
}

.course-form {
  max-width: 1200px;
  margin: 0 auto;
}

.form-grid {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.form-section {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.form-section.full-width {
  grid-column: 1 / -1;
}

.section-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 1.3rem;
  color: var(--eerie-black-1);
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 2px solid var(--isabelline);
}

.section-title ion-icon {
  color: var(--kappel);
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
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

.form-hint {
  display: block;
  margin-top: 5px;
  font-size: 0.8rem;
  color: var(--gray-web);
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  font-weight: 500;
}

.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  margin: 0;
}

.image-upload-area {
  text-align: center;
}

.current-image {
  position: relative;
  display: inline-block;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
}

.current-image img {
  width: 300px;
  height: 200px;
  object-fit: cover;
  display: block;
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.current-image:hover .image-overlay {
  opacity: 1;
}

.upload-placeholder {
  width: 300px;
  height: 200px;
  border: 3px dashed var(--kappel);
  border-radius: 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  margin: 0 auto;
}

.upload-placeholder:hover {
  border-color: #0F766E;
  background: rgba(20, 184, 166, 0.05);
}

.upload-placeholder ion-icon {
  font-size: 3rem;
  color: var(--kappel);
  margin-bottom: 15px;
}

.upload-placeholder p {
  font-size: 1.1rem;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
  font-weight: 600;
}

.upload-hint {
  font-size: 0.9rem;
  color: var(--gray-web);
}

.form-actions {
  display: flex;
  gap: 20px;
  justify-content: center;
  margin-top: 40px;
  padding-top: 30px;
  border-top: 2px solid var(--isabelline);
}

.btn {
  padding: 15px 30px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
  min-width: 120px;
  justify-content: center;
}

.btn-primary {
  background: var(--kappel);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #0F766E;
}

.btn-outline {
  background: transparent;
  color: var(--kappel);
  border: 2px solid var(--kappel);
}

.btn-outline:hover:not(:disabled) {
  background: var(--kappel);
  color: white;
}

.btn-danger {
  background: #DC2626;
  color: white;
}

.btn-danger:hover:not(:disabled) {
  background: #B91C1C;
}

.btn-sm {
  padding: 8px 16px;
  font-size: 0.9rem;
  min-width: auto;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
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

.course-preview {
  padding: 20px 0;
}

.preview-header {
  display: flex;
  gap: 30px;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 2px solid var(--isabelline);
}

.preview-image {
  flex-shrink: 0;
}

.preview-image img {
  width: 250px;
  height: 180px;
  object-fit: cover;
  border-radius: 10px;
}

.preview-info {
  flex: 1;
}

.preview-info h2 {
  font-size: 1.8rem;
  color: var(--eerie-black-1);
  margin-bottom: 15px;
}

.preview-description {
  color: var(--gray-web);
  line-height: 1.6;
  margin-bottom: 20px;
}

.preview-meta {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.preview-meta span {
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.preview-meta .level {
  background: var(--kappel);
  color: white;
}

.preview-meta .duration {
  background: var(--selective-yellow);
  color: var(--eerie-black-1);
}

.preview-meta .price {
  background: #10B981;
  color: white;
}

.preview-content {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.preview-section h4 {
  font-size: 1.2rem;
  color: var(--eerie-black-1);
  margin-bottom: 10px;
}

.preview-section p {
  color: var(--gray-web);
  line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    text-align: center;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .form-actions {
    flex-direction: column;
    align-items: center;
  }
  
  .preview-header {
    flex-direction: column;
    text-align: center;
  }
  
  .preview-image img {
    width: 100%;
    max-width: 300px;
  }
  
  .upload-placeholder,
  .current-image img {
    width: 100%;
    max-width: 300px;
  }
}
</style>


