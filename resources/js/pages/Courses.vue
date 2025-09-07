<template>
  <main>
    <!-- Courses Hero Section -->
    <section class="hero courses-hero" aria-label="courses hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="h1 hero-title">
            Explore Our <span class="span">Courses</span>
          </h1>
          <p class="hero-text">
            Discover hundreds of high-quality courses designed by industry experts. From beginner to advanced, find the perfect course to advance your career and achieve your learning goals.
          </p>
          <div class="search-box">
            <input 
              type="text" 
              v-model="searchQuery" 
              placeholder="Search for courses..." 
              class="search-input"
              @input="filterCourses"
            >
            <button class="search-btn">
              <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
            </button>
          </div>
          <!-- Auth Buttons -->
          <div class="hero-auth-buttons">
            <router-link to="/login" class="btn btn-outline auth-btn">
              <span class="span">Login</span>
              <ion-icon name="log-in-outline" aria-hidden="true"></ion-icon>
            </router-link>
            <router-link to="/signup" class="btn btn-primary auth-btn">
              <span class="span">Sign Up</span>
              <ion-icon name="person-add-outline" aria-hidden="true"></ion-icon>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Course Categories Section -->
    <section class="section categories" aria-label="course categories">
      <div class="container">
        <div class="section-header">
          <h2 class="h2 section-title">
            Browse by <span class="span">Category</span>
          </h2>
          <p class="section-text">
            Choose from our wide range of categories to find your perfect learning path
          </p>
        </div>
        <div class="categories-grid">
          <div 
            class="category-card" 
            v-for="category in categories" 
            :key="category.id"
            :class="{ active: selectedCategory === category.id }"
            @click="selectCategory(category.id)"
          >
            <div class="category-icon">
              <ion-icon :name="category.icon" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="category-title">{{ category.title }}</h3>
            <p class="category-count">{{ category.courses }} Courses</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Courses Section -->
    <section class="section featured-courses" aria-label="featured courses">
      <div class="container">
        <div class="section-header">
          <h2 class="h2 section-title">
            Featured <span class="span">Courses</span>
          </h2>
          <p class="section-text">
            Our most popular and highly-rated courses chosen by thousands of students
          </p>
        </div>
        
        <!-- Filters -->
        <div class="filters">
          <div class="filter-group">
            <label class="filter-label">Level:</label>
            <select v-model="selectedLevel" @change="filterCourses" class="filter-select">
              <option value="">All Levels</option>
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advanced">Advanced</option>
            </select>
          </div>
          <div class="filter-group">
            <label class="filter-label">Price:</label>
            <select v-model="selectedPrice" @change="filterCourses" class="filter-select">
              <option value="">All Prices</option>
              <option value="free">Free</option>
              <option value="paid">Paid</option>
            </select>
          </div>
          <div class="filter-group">
            <label class="filter-label">Rating:</label>
            <select v-model="selectedRating" @change="filterCourses" class="filter-select">
              <option value="">All Ratings</option>
              <option value="4.5">4.5+ Stars</option>
              <option value="4.0">4.0+ Stars</option>
              <option value="3.5">3.5+ Stars</option>
            </select>
          </div>
        </div>

        <!-- Course Grid -->
        <div class="courses-grid">
          <div 
            class="course-card" 
            v-for="course in filteredCourses" 
            :key="course.id"
          >
            <div class="course-image">
              <img :src="course.image" :alt="course.title" class="w-100">
              <div class="course-overlay">
                <router-link :to="`/courses/${course.id}`" class="btn-overlay">
                  <ion-icon name="play-circle-outline" aria-hidden="true"></ion-icon>
                </router-link>
              </div>
              <div class="course-badge" v-if="course.isNew">New</div>
              <div class="course-badge hot" v-if="course.isHot">Hot</div>
            </div>
            
            <div class="course-content">
              <div class="course-header">
                <span class="course-level">{{ course.level }}</span>
                <div class="course-rating">
                  <ion-icon name="star" aria-hidden="true"></ion-icon>
                  <span>{{ course.rating }}</span>
                  <span class="rating-count">({{ course.reviews }})</span>
                </div>
              </div>
              
              <h3 class="course-title">
                <router-link :to="`/courses/${course.id}`">{{ course.title }}</router-link>
              </h3>
              
              <p class="course-description">{{ course.description }}</p>
              
              <div class="course-meta">
                <div class="meta-item">
                  <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                  <span>{{ course.duration }}</span>
                </div>
                <div class="meta-item">
                  <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
                  <span>{{ course.lessons }} Lessons</span>
                </div>
                <div class="meta-item">
                  <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                  <span>{{ course.students }} Students</span>
                </div>
              </div>
              
              <div class="course-footer">
                <div class="instructor">
                  <img :src="course.instructor.avatar" :alt="course.instructor.name" class="instructor-avatar">
                  <span class="instructor-name">{{ course.instructor.name }}</span>
                </div>
                <div class="course-price">
                  <span class="price" v-if="course.price > 0">${{ course.price }}</span>
                  <span class="price free" v-else>Free</span>
                  <del class="original-price" v-if="course.originalPrice > course.price">${{ course.originalPrice }}</del>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Load More Button -->
        <div class="load-more" v-if="hasMoreCourses">
          <button class="btn has-before" @click="loadMoreCourses">
            <span class="span">Load More Courses</span>
            <ion-icon name="arrow-down-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>
      </div>
    </section>

    <!-- Course Stats Section -->
    <section class="section course-stats" aria-label="course statistics">
      <div class="container">
        <div class="stats-grid">
          <div class="stat-card" v-for="stat in stats" :key="stat.id">
            <div class="stat-icon">
              <ion-icon :name="stat.icon" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="stat-number">{{ stat.value }}</h3>
            <p class="stat-label">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta" aria-label="call to action">
      <div class="container">
        <div class="cta-content">
          <h2 class="h2 cta-title">
            Ready to Start <span class="span">Learning?</span>
          </h2>
          <p class="cta-text">
            Join thousands of students who have already transformed their careers with our courses
          </p>
          <div class="cta-actions">
            <router-link to="/signup" class="btn has-before">
              <span class="span">Get Started Free</span>
              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </router-link>
            <router-link to="/contact" class="btn-outline">
              <span class="span">Need Help?</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'Courses',
  data() {
    return {
      searchQuery: '',
      selectedCategory: null,
      selectedLevel: '',
      selectedPrice: '',
      selectedRating: '',
      coursesPerPage: 9,
      currentPage: 1,
      categories: [
        {
          id: 1,
          title: 'Web Development',
          icon: 'code-slash-outline',
          courses: 45
        },
        {
          id: 2,
          title: 'Mobile Development',
          icon: 'phone-portrait-outline',
          courses: 32
        },
        {
          id: 3,
          title: 'Data Science',
          icon: 'analytics-outline',
          courses: 28
        },
        {
          id: 4,
          title: 'UI/UX Design',
          icon: 'color-palette-outline',
          courses: 25
        },
        {
          id: 5,
          title: 'Business & Marketing',
          icon: 'business-outline',
          courses: 38
        },
        {
          id: 6,
          title: 'Digital Marketing',
          icon: 'trending-up-outline',
          courses: 22
        }
      ],
      allCourses: [
        {
          id: 1,
          title: 'Complete Web Development Bootcamp 2024',
          description: 'Learn HTML, CSS, JavaScript, React, Node.js and more! Build real-world projects and become a full-stack developer.',
          image: 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80',
          level: 'Beginner',
          rating: 4.8,
          reviews: 1250,
          duration: '6.5 hours',
          lessons: 45,
          students: 1250,
          price: 89.99,
          originalPrice: 199.99,
          category: 1,
          instructor: {
            name: 'Dr. Sarah Johnson',
            avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'
          },
          isNew: true,
          isHot: false
        },
        {
          id: 2,
          title: 'Python for Data Science & Machine Learning',
          description: 'Master Python programming for data analysis, visualization, and machine learning with hands-on projects.',
          image: 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2074&q=80',
          level: 'Intermediate',
          rating: 4.9,
          reviews: 980,
          duration: '8.2 hours',
          lessons: 38,
          students: 980,
          price: 79.99,
          originalPrice: 149.99,
          category: 3,
          instructor: {
            name: 'Michael Chen',
            avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80'
          },
          isNew: false,
          isHot: true
        },
        {
          id: 3,
          title: 'Mobile App Development with Flutter',
          description: 'Build cross-platform mobile apps with Flutter framework and Dart programming language.',
          image: 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
          level: 'Advanced',
          rating: 4.7,
          reviews: 750,
          duration: '10.5 hours',
          lessons: 52,
          students: 750,
          price: 99.99,
          originalPrice: 179.99,
          category: 2,
          instructor: {
            name: 'Emily Rodriguez',
            avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80'
          },
          isNew: false,
          isHot: false
        },
        {
          id: 4,
          title: 'UI/UX Design Masterclass',
          description: 'Learn modern design principles, tools, and techniques to create beautiful user interfaces.',
          image: 'https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80',
          level: 'Beginner',
          rating: 4.6,
          reviews: 620,
          duration: '7.8 hours',
          lessons: 42,
          students: 620,
          price: 69.99,
          originalPrice: 129.99,
          category: 4,
          instructor: {
            name: 'David Thompson',
            avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'
          },
          isNew: true,
          isHot: false
        },
        {
          id: 5,
          title: 'Digital Marketing Fundamentals',
          description: 'Master the basics of digital marketing including SEO, social media, and content marketing.',
          image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1115&q=80',
          level: 'Beginner',
          rating: 4.5,
          reviews: 890,
          duration: '5.5 hours',
          lessons: 35,
          students: 890,
          price: 0,
          originalPrice: 99.99,
          category: 6,
          instructor: {
            name: 'Lisa Wang',
            avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=688&q=80'
          },
          isNew: false,
          isHot: true
        },
        {
          id: 6,
          title: 'React.js Complete Guide',
          description: 'Learn React.js from scratch to advanced concepts with real-world projects and best practices.',
          image: 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
          level: 'Intermediate',
          rating: 4.8,
          reviews: 1100,
          duration: '9.2 hours',
          lessons: 48,
          students: 1100,
          price: 84.99,
          originalPrice: 159.99,
          category: 1,
          instructor: {
            name: 'Alex Kumar',
            avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'
          },
          isNew: false,
          isHot: false
        }
      ],
      stats: [
        {
          id: 1,
          icon: 'library-outline',
          value: '500+',
          label: 'Courses Available'
        },
        {
          id: 2,
          icon: 'people-outline',
          value: '50K+',
          label: 'Students Enrolled'
        },
        {
          id: 3,
          icon: 'star-outline',
          value: '4.8',
          label: 'Average Rating'
        },
        {
          id: 4,
          icon: 'school-outline',
          value: '200+',
          label: 'Expert Instructors'
        }
      ]
    }
  },
  computed: {
    filteredCourses() {
      let filtered = this.allCourses;

      // Search filter
      if (this.searchQuery) {
        filtered = filtered.filter(course => 
          course.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          course.description.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          course.instructor.name.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }

      // Category filter
      if (this.selectedCategory) {
        filtered = filtered.filter(course => course.category === this.selectedCategory);
      }

      // Level filter
      if (this.selectedLevel) {
        filtered = filtered.filter(course => course.level === this.selectedLevel);
      }

      // Price filter
      if (this.selectedPrice === 'free') {
        filtered = filtered.filter(course => course.price === 0);
      } else if (this.selectedPrice === 'paid') {
        filtered = filtered.filter(course => course.price > 0);
      }

      // Rating filter
      if (this.selectedRating) {
        filtered = filtered.filter(course => course.rating >= parseFloat(this.selectedRating));
      }

      return filtered.slice(0, this.currentPage * this.coursesPerPage);
    },
    hasMoreCourses() {
      return this.filteredCourses.length < this.allCourses.length;
    }
  },
  methods: {
    selectCategory(categoryId) {
      this.selectedCategory = this.selectedCategory === categoryId ? null : categoryId;
      this.filterCourses();
    },
    filterCourses() {
      this.currentPage = 1;
    },
    loadMoreCourses() {
      this.currentPage++;
    }
  }
}
</script>

<style scoped>
.courses-hero {
  padding: 120px 0 80px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  text-align: center;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.hero-title {
  font-size: clamp(2rem, 5vw, 3.5rem);
  line-height: 1.2;
  margin-bottom: 20px;
  font-weight: 700;
}

.hero-text {
  font-size: clamp(1rem, 2.5vw, 1.2rem);
  line-height: 1.6;
  margin-bottom: 40px;
  opacity: 0.9;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.search-box {
  display: flex;
  max-width: 500px;
  margin: 0 auto;
  background: white;
  border-radius: 50px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.search-input {
  flex: 1;
  padding: 20px 25px;
  border: none;
  outline: none;
  font-size: 1.1rem;
}

.search-btn {
  padding: 20px 25px;
  background: var(--primary-color);
  border: none;
  color: white;
  cursor: pointer;
  transition: background 0.3s ease;
}

.search-btn:hover {
  background: var(--secondary-color);
}

.categories {
  padding: 80px 0;
  background: var(--light-bg);
}

.section-header {
  text-align: center;
  margin-bottom: 60px;
}

.section-text {
  font-size: 1.1rem;
  color: var(--text-light);
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.category-card {
  background: white;
  padding: 30px 20px;
  border-radius: 15px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.category-card:hover,
.category-card.active {
  transform: translateY(-5px);
  border-color: var(--primary-color);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.category-icon {
  width: 60px;
  height: 60px;
  margin: 0 auto 15px;
  background: var(--primary-color);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.category-icon ion-icon {
  font-size: 1.5rem;
  color: white;
}

.category-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--text-color);
  margin-bottom: 5px;
}

.category-count {
  color: var(--text-light);
  font-size: 0.9rem;
}

.featured-courses {
  padding: 80px 0;
}

.filters {
  display: flex;
  gap: 20px;
  margin-bottom: 40px;
  flex-wrap: wrap;
  justify-content: center;
}

.filter-group {
  display: flex;
  align-items: center;
  gap: 10px;
}

.filter-label {
  font-weight: 500;
  color: var(--text-color);
}

.filter-select {
  padding: 10px 15px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  background: white;
  color: var(--text-color);
  outline: none;
  cursor: pointer;
}

.courses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  margin-bottom: 50px;
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
  overflow: hidden;
}

.course-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.course-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.course-card:hover .course-overlay {
  opacity: 1;
}

.btn-overlay {
  width: 60px;
  height: 60px;
  background: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--primary-color);
  font-size: 1.5rem;
  transition: transform 0.3s ease;
}

.btn-overlay:hover {
  transform: scale(1.1);
}

.course-badge {
  position: absolute;
  top: 15px;
  left: 15px;
  padding: 5px 12px;
  background: var(--primary-color);
  color: white;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.course-badge.hot {
  background: #ff6b6b;
}

.course-content {
  padding: 25px;
}

.course-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.course-level {
  padding: 4px 12px;
  background: var(--light-bg);
  color: var(--primary-color);
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.course-rating {
  display: flex;
  align-items: center;
  gap: 5px;
  color: #ffc107;
}

.course-rating ion-icon {
  font-size: 1rem;
}

.rating-count {
  color: var(--text-light);
  font-size: 0.9rem;
}

.course-title {
  margin-bottom: 10px;
}

.course-title a {
  color: var(--text-color);
  text-decoration: none;
  font-size: 1.2rem;
  font-weight: 600;
  line-height: 1.4;
}

.course-title a:hover {
  color: var(--primary-color);
}

.course-description {
  color: var(--text-light);
  line-height: 1.6;
  margin-bottom: 20px;
  font-size: 0.95rem;
}

.course-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 5px;
  color: var(--text-light);
  font-size: 0.9rem;
}

.course-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 20px;
  border-top: 1px solid var(--border-color);
}

.instructor {
  display: flex;
  align-items: center;
  gap: 10px;
}

.instructor-avatar {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  object-fit: cover;
}

.instructor-name {
  color: var(--text-color);
  font-size: 0.9rem;
  font-weight: 500;
}

.course-price {
  text-align: right;
}

.price {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--primary-color);
}

.price.free {
  color: #28a745;
}

.original-price {
  color: var(--text-light);
  text-decoration: line-through;
  margin-left: 10px;
  font-size: 0.9rem;
}

.load-more {
  text-align: center;
}

.course-stats {
  padding: 80px 0;
  background: var(--light-bg);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 30px;
}

.stat-card {
  text-align: center;
  padding: 40px 20px;
  background: white;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.stat-icon {
  width: 70px;
  height: 70px;
  margin: 0 auto 20px;
  background: var(--primary-color);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-icon ion-icon {
  font-size: 1.8rem;
  color: white;
}

.stat-number {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--primary-color);
  margin-bottom: 10px;
}

.stat-label {
  color: var(--text-light);
  font-size: 1rem;
  font-weight: 500;
}

.cta {
  padding: 100px 0;
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  color: white;
  text-align: center;
}

.cta-title {
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.cta-text {
  font-size: 1.2rem;
  margin-bottom: 40px;
  opacity: 0.9;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.cta-actions {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-outline {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 15px 30px;
  border: 2px solid white;
  border-radius: 8px;
  color: white;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-outline:hover {
  background: white;
  color: var(--primary-color);
}

/* Hero Auth Buttons */
.hero-auth-buttons {
  display: flex;
  gap: 15px;
  margin-top: 30px;
  flex-wrap: wrap;
}

.auth-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  cursor: pointer;
  white-space: nowrap;
}

.btn-primary {
  background: var(--primary-color);
  color: white;
  border-color: var(--primary-color);
}

.btn-primary:hover {
  background: var(--secondary-color);
  border-color: var(--secondary-color);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-outline {
  background: transparent;
  color: var(--primary-color);
  border-color: var(--primary-color);
}

.btn-outline:hover {
  background: var(--primary-color);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 1200px) {
  .hero-title {
    font-size: clamp(2.5rem, 4vw, 3rem);
  }
  
  .hero-text {
    font-size: clamp(1rem, 2vw, 1.1rem);
  }
  
  .courses-grid {
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  }
}

@media (max-width: 1024px) {
  .courses-hero {
    padding: 100px 0 60px;
    min-height: auto;
  }
  
  .hero-title {
    font-size: clamp(2rem, 5vw, 2.5rem);
  }
  
  .hero-text {
    font-size: clamp(0.95rem, 2.5vw, 1rem);
  }
  
  .search-box {
    max-width: 400px;
  }
  
  .categories-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  }
  
  .courses-grid {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  }
}

@media (max-width: 768px) {
  .courses-hero {
    padding: 80px 0 50px;
  }
  
  .hero-title {
    font-size: clamp(1.8rem, 5vw, 2.2rem);
  }
  
  .hero-text {
    font-size: clamp(0.9rem, 2.5vw, 0.95rem);
  }
  
  .hero-auth-buttons {
    justify-content: center;
    gap: 10px;
  }
  
  .search-box {
    flex-direction: column;
    border-radius: 15px;
    max-width: 100%;
  }
  
  .search-input,
  .search-btn {
    border-radius: 0;
  }
  
  .categories-grid {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  }
  
  .filters {
    flex-direction: column;
    align-items: center;
    gap: 15px;
  }
  
  .courses-grid {
    grid-template-columns: 1fr;
  }
  
  .course-meta {
    flex-direction: column;
    gap: 10px;
  }
  
  .course-footer {
    flex-direction: column;
    gap: 15px;
    align-items: flex-start;
  }
  
  .cta-actions {
    flex-direction: column;
    align-items: center;
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
  .courses-hero {
    padding: 60px 0 40px;
  }
  
  .hero-title {
    font-size: clamp(1.6rem, 6vw, 1.8rem);
    line-height: 1.3;
  }
  
  .hero-text {
    font-size: clamp(0.85rem, 3vw, 0.9rem);
    line-height: 1.5;
  }
  
  .hero-auth-buttons {
    flex-direction: column;
    width: 100%;
  }
  
  .auth-btn {
    width: 100%;
    justify-content: center;
  }
  
  .search-input {
    padding: clamp(12px, 3vw, 15px) clamp(16px, 4vw, 20px);
    font-size: clamp(0.9rem, 2.5vw, 1rem);
  }
  
  .search-btn {
    padding: clamp(12px, 3vw, 15px) clamp(16px, 4vw, 20px);
  }
  
  .categories-grid {
    grid-template-columns: 1fr;
  }
  
  .category-card {
    padding: clamp(15px, 4vw, 20px) clamp(12px, 3vw, 15px);
  }
  
  .course-content {
    padding: clamp(15px, 4vw, 20px);
  }
  
  .course-title a {
    font-size: clamp(1rem, 2.5vw, 1.1rem);
  }
  
  .course-description {
    font-size: clamp(0.85rem, 2.5vw, 0.9rem);
  }
  
  .cta-title {
    font-size: clamp(1.6rem, 4vw, 1.8rem);
  }
  
  .cta-text {
    font-size: clamp(0.9rem, 2.5vw, 0.95rem);
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
  
  .courses-grid,
  .categories-grid {
    gap: 20px;
  }
  
  .course-card,
  .category-card {
    margin: 0 10px;
  }
}

@media (max-width: 360px) {
  .hero-title {
    font-size: clamp(1.4rem, 6vw, 1.6rem);
  }
  
  .hero-text {
    font-size: clamp(0.8rem, 3vw, 0.85rem);
  }
  
  .btn {
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
    font-size: clamp(0.8rem, 2.5vw, 0.85rem);
  }
  
  .search-input,
  .search-btn {
    padding: clamp(10px, 2.5vw, 12px) clamp(12px, 3vw, 16px);
  }
  
  .hero-auth-buttons {
    gap: 8px;
  }
}
</style>
