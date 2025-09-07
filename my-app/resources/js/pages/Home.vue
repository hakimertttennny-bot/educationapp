<template>
  <main>
    <!-- Hero Section -->
    <section class="hero" id="home" aria-label="home">
      <div class="container">
        <div class="hero-content">
          <h1 class="h1 hero-title">
            The Best Way to <span class="span">Learn</span> That Suits You
          </h1>
          <p class="hero-text">
            Discover thousands of online courses from top instructors around the world. Learn at your own pace, on your own schedule, and transform your career with our comprehensive learning platform.
          </p>
          <div class="hero-actions">
            <router-link to="/courses" class="btn has-before">
              <span class="span">Explore Courses</span>
              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </router-link>
            <a href="#how-it-works" class="btn-outline">
              <span class="span">How It Works</span>
              <ion-icon name="play-circle-outline" aria-hidden="true"></ion-icon>
            </a>
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
          <div class="hero-stats">
            <div class="stat-item">
              <h3 class="stat-number">50K+</h3>
              <p class="stat-label">Students Enrolled</p>
            </div>
            <div class="stat-item">
              <h3 class="stat-number">200+</h3>
              <p class="stat-label">Expert Instructors</p>
            </div>
            <div class="stat-item">
              <h3 class="stat-number">95%</h3>
              <p class="stat-label">Success Rate</p>
            </div>
          </div>
        </div>
        <figure class="hero-banner">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="hero banner" class="w-100">
        </figure>
      </div>
    </section>

    <!-- Course Categories Section -->
    <section class="section category" aria-label="category">
      <div class="container">
        <div class="section-header">
          <p class="section-subtitle">Course Categories</p>
          <h2 class="h2 section-title">
            Popular Topics to <span class="span">Learn</span>
          </h2>
          <p class="section-text">
            Choose from our wide range of categories and start your learning journey today
          </p>
        </div>
        <ul class="grid-list">
          <li v-for="category in categories" :key="category.id">
            <div class="category-card">
              <div class="card-icon">
                <ion-icon :name="category.icon" aria-hidden="true"></ion-icon>
              </div>
              <h3 class="h3">
                <router-link to="/courses" class="card-title">{{ category.title }}</router-link>
              </h3>
              <p class="card-text">{{ category.description }}</p>
              <span class="card-badge">{{ category.courses }} Courses</span>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="section how-it-works" id="how-it-works" aria-label="how it works">
      <div class="container">
        <div class="section-header">
          <p class="section-subtitle">How It Works</p>
          <h2 class="h2 section-title">
            Start Learning in <span class="span">3 Simple Steps</span>
          </h2>
        </div>
        <ul class="steps-list">
          <li v-for="step in steps" :key="step.id" class="step-item">
            <div class="step-number">{{ step.number }}</div>
            <div class="step-content">
              <h3 class="h3">{{ step.title }}</h3>
              <p class="step-text">{{ step.description }}</p>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <!-- Featured Courses Section -->
    <section class="section course" id="courses" aria-label="course">
      <div class="container">
        <div class="section-header">
          <p class="section-subtitle">Featured Courses</p>
          <h2 class="h2 section-title">
            Most Popular <span class="span">Courses</span>
          </h2>
          <p class="section-text">
            Join thousands of students learning from our top-rated courses
          </p>
        </div>
        <ul class="grid-list">
          <li v-for="course in courses" :key="course.id">
            <div class="course-card">
              <figure class="card-banner">
                <img :src="course.image" width="370" height="270" loading="lazy" :alt="course.title" class="img-cover">
                <div class="card-overlay">
                  <router-link to="/courses" class="btn-overlay">
                    <ion-icon name="play-circle-outline" aria-hidden="true"></ion-icon>
                  </router-link>
                </div>
              </figure>
              <div class="card-actions">
                <span class="meta">
                  <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
                  <span class="span">{{ course.lessons }} Lessons</span>
                </span>
                <span class="meta">
                  <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                  <span class="span">{{ course.duration }}</span>
                </span>
              </div>
              <div class="card-content">
                <div class="card-header">
                  <span class="badge">{{ course.level }}</span>
                  <div class="rating">
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <span class="rating-text">{{ course.rating }}</span>
                  </div>
                </div>
                <h3 class="h3">
                  <router-link to="/courses" class="card-title">{{ course.title }}</router-link>
                </h3>
                <p class="card-text">{{ course.description }}</p>
                <div class="card-footer">
                  <div class="card-meta">
                    <span class="students">
                      <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                      {{ course.students }} Students
                    </span>
                  </div>
                  <div class="card-price">
                    <span class="price">${{ course.price }}</span>
                    <del class="original-price">${{ course.originalPrice }}</del>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <div class="section-footer">
          <router-link to="/courses" class="btn has-before">
            <span class="span">View All Courses</span>
            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
          </router-link>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section testimonials" aria-label="testimonials">
      <div class="container">
        <div class="section-header">
          <p class="section-subtitle">Testimonials</p>
          <h2 class="h2 section-title">
            What Our <span class="span">Students Say</span>
          </h2>
        </div>
        <ul class="testimonials-list">
          <li v-for="testimonial in testimonials" :key="testimonial.id" class="testimonial-item">
            <div class="testimonial-card">
              <div class="testimonial-content">
                <p class="testimonial-text">{{ testimonial.text }}</p>
                <div class="testimonial-author">
                  <img :src="testimonial.avatar" :alt="testimonial.name" class="author-avatar">
                  <div class="author-info">
                    <h4 class="author-name">{{ testimonial.name }}</h4>
                    <p class="author-title">{{ testimonial.title }}</p>
                    <div class="rating">
                      <ion-icon v-for="star in 5" :key="star" name="star" aria-hidden="true"></ion-icon>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta" aria-label="call to action">
      <div class="container">
        <div class="cta-content">
          <h2 class="h2 cta-title">
            Ready to Start Your <span class="span">Learning Journey?</span>
          </h2>
          <p class="cta-text">
            Join thousands of students who have already transformed their careers with our courses
          </p>
          <div class="cta-actions">
            <router-link to="/signup" class="btn has-before">
              <span class="span">Get Started Free</span>
              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </router-link>
            <router-link to="/courses" class="btn-outline">
              <span class="span">Browse Courses</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      categories: [
        {
          id: 1,
          icon: 'code-slash-outline',
          title: 'Web Development',
          description: 'Learn modern web development with the latest technologies like React, Vue, and Node.js.',
          courses: 15
        },
        {
          id: 2,
          icon: 'phone-portrait-outline',
          title: 'Mobile Development',
          description: 'Build mobile apps for iOS and Android platforms using Flutter, React Native, and Swift.',
          courses: 12
        },
        {
          id: 3,
          icon: 'color-palette-outline',
          title: 'UI/UX Design',
          description: 'Create beautiful and functional user interfaces with modern design tools and principles.',
          courses: 8
        },
        {
          id: 4,
          icon: 'analytics-outline',
          title: 'Data Science',
          description: 'Master data analysis and machine learning with Python, R, and advanced analytics tools.',
          courses: 20
        },
        {
          id: 5,
          icon: 'business-outline',
          title: 'Business & Marketing',
          description: 'Learn business strategies, digital marketing, and entrepreneurship skills.',
          courses: 10
        },
        {
          id: 6,
          icon: 'language-outline',
          title: 'Languages',
          description: 'Master new languages and communication skills for global opportunities.',
          courses: 6
        }
      ],
      steps: [
        {
          id: 1,
          number: '01',
          title: 'Choose Your Course',
          description: 'Browse our extensive catalog and select the course that matches your learning goals.'
        },
        {
          id: 2,
          number: '02',
          title: 'Learn at Your Pace',
          description: 'Access high-quality video lessons, interactive exercises, and real-world projects.'
        },
        {
          id: 3,
          number: '03',
          title: 'Get Certified',
          description: 'Complete your course and earn a certificate to showcase your new skills.'
        }
      ],
      courses: [
        {
          id: 1,
          title: 'Complete Web Development Bootcamp 2024',
          description: 'Learn HTML, CSS, JavaScript, React, Node.js and more! Build real-world projects.',
          image: 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          lessons: 45,
          duration: '6.5 hours',
          students: 1250,
          rating: 4.8,
          price: 89.99,
          originalPrice: 199.99,
          level: 'Beginner'
        },
        {
          id: 2,
          title: 'Python for Data Science & Machine Learning',
          description: 'Master Python programming for data analysis, visualization, and machine learning.',
          image: 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          lessons: 38,
          duration: '8.2 hours',
          students: 980,
          rating: 4.9,
          price: 79.99,
          originalPrice: 149.99,
          level: 'Intermediate'
        },
        {
          id: 3,
          title: 'Mobile App Development with Flutter',
          description: 'Build cross-platform mobile apps with Flutter framework and Dart programming.',
          image: 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          lessons: 52,
          duration: '10.5 hours',
          students: 750,
          rating: 4.7,
          price: 99.99,
          originalPrice: 179.99,
          level: 'Advanced'
        }
      ],
      testimonials: [
        {
          id: 1,
          text: "EduWeb transformed my career! The web development course was comprehensive and practical. I landed my dream job within 3 months of completing the course.",
          name: "Sarah Johnson",
          title: "Frontend Developer at TechCorp",
          avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
        },
        {
          id: 2,
          text: "The instructors are world-class and the content is always up-to-date. I learned more in 6 months here than in 2 years of traditional education.",
          name: "Michael Chen",
          title: "Data Scientist at DataFlow",
          avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
        },
        {
          id: 3,
          text: "Perfect for busy professionals! I could learn at my own pace and the community support was incredible. Highly recommended!",
          name: "Emily Rodriguez",
          title: "UX Designer at DesignStudio",
          avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
        }
      ]
    }
  }
}
</script>

<style scoped>
.hero {
  padding: 120px 0 80px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  position: relative;
  overflow: hidden;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
  opacity: 0.3;
}

.hero .container {
  position: relative;
  z-index: 1;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.hero-banner {
  position: relative;
}

.hero-banner img {
  max-width: 100%;
  height: auto;
  border-radius: 15px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
  object-fit: cover;
  aspect-ratio: 1/1;
  max-height: 600px;
  min-height: 500px;
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
  margin-bottom: 30px;
  opacity: 0.9;
  max-width: 500px;
}

.hero-actions {
  display: flex;
  gap: 20px;
  margin-bottom: 40px;
  flex-wrap: wrap;
  align-items: center;
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
  color: var(--kappel);
}

.hero-stats {
  display: flex;
  gap: 40px;
  flex-wrap: wrap;
  margin-top: 40px;
}

.stat-item {
  text-align: center;
}

.stat-number {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 0.9rem;
  opacity: 0.8;
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

.how-it-works {
  padding: 100px 0;
  background: var(--light-bg);
}

.steps-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 40px;
  margin-top: 60px;
}

.step-item {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  padding: 30px;
  background: white;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.step-item:hover {
  transform: translateY(-5px);
}

.step-number {
  width: 60px;
  height: 60px;
  background: var(--primary-color);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: 700;
  flex-shrink: 0;
}

.step-content h3 {
  margin-bottom: 10px;
  color: var(--text-color);
}

.step-text {
  color: var(--text-light);
  line-height: 1.6;
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

.card-banner {
  position: relative;
  overflow: hidden;
}

.card-banner img {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-radius: 15px 15px 0 0;
}

.card-overlay {
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

.course-card:hover .card-overlay {
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

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.badge {
  padding: 4px 12px;
  background: var(--primary-color);
  color: white;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.rating {
  display: flex;
  align-items: center;
  gap: 5px;
  color: #ffc107;
}

.rating ion-icon {
  font-size: 1rem;
}

.rating-text {
  color: var(--text-color);
  font-weight: 500;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--border-color);
}

.students {
  display: flex;
  align-items: center;
  gap: 5px;
  color: var(--text-light);
  font-size: 0.9rem;
}

.price {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--primary-color);
}

.original-price {
  color: var(--text-light);
  text-decoration: line-through;
  margin-left: 10px;
}

.section-footer {
  text-align: center;
  margin-top: 50px;
}

.testimonials {
  padding: 100px 0;
  background: var(--light-bg);
}

.testimonials-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  margin-top: 60px;
}

.testimonial-card {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.testimonial-text {
  font-style: italic;
  color: var(--text-color);
  line-height: 1.6;
  margin-bottom: 20px;
  font-size: 1.1rem;
}

.testimonial-author {
  display: flex;
  align-items: center;
  gap: 15px;
}

.author-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
}

.author-name {
  font-weight: 600;
  color: var(--text-color);
  margin-bottom: 5px;
}

.author-title {
  color: var(--text-light);
  font-size: 0.9rem;
  margin-bottom: 5px;
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
  background: var(--kappel);
  color: white;
  border-color: var(--kappel);
}

.btn-primary:hover {
  background: var(--selective-yellow);
  border-color: var(--selective-yellow);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-outline {
  background: transparent;
  color: var(--kappel);
  border-color: var(--kappel);
}

.btn-outline:hover {
  background: var(--kappel);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 1200px) {
  .hero .container {
    gap: 40px;
  }
  
  .hero-title {
    font-size: clamp(2.5rem, 4vw, 3rem);
  }
  
  .hero-text {
    font-size: clamp(1rem, 2vw, 1.1rem);
  }
}

@media (max-width: 1024px) {
  .hero {
    padding: 100px 0 60px;
    min-height: auto;
  }
  
  .hero .container {
    grid-template-columns: 1fr;
    gap: 40px;
    text-align: center;
  }
  
  .hero-banner {
    order: -1;
  }
  
  .hero-text {
    max-width: 100%;
    margin: 0 auto 30px;
  }
  
  .hero-actions {
    justify-content: center;
  }
  
  .hero-stats {
    justify-content: center;
  }
  
  .steps-list {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  }
  
  .testimonials-list {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  }
}

@media (max-width: 768px) {
  .hero {
    padding: 80px 0 50px;
  }
  
  .hero-title {
    font-size: clamp(2rem, 5vw, 2.5rem);
  }
  
  .hero-text {
    font-size: clamp(0.95rem, 2.5vw, 1rem);
  }
  
  .hero-actions {
    flex-direction: column;
    align-items: center;
    gap: 15px;
  }
  
  .hero-auth-buttons {
    justify-content: center;
    gap: 10px;
    margin-top: 25px;
  }
  
  .hero-stats {
    gap: 30px;
  }
  
  .steps-list {
    grid-template-columns: 1fr;
  }
  
  .testimonials-list {
    grid-template-columns: 1fr;
  }
  
  .cta-actions {
    flex-direction: column;
    align-items: center;
  }
  
  .grid-list {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
  .hero {
    padding: 60px 0 40px;
  }
  
  .hero-title {
    font-size: clamp(1.8rem, 6vw, 2rem);
    line-height: 1.3;
  }
  
  .hero-text {
    font-size: clamp(0.9rem, 3vw, 0.95rem);
    line-height: 1.5;
  }
  
  .hero-banner img {
    max-height: 400px;
    min-height: 350px;
  }
  
  .card-banner img {
    height: 200px;
  }
  
  .hero-actions {
    gap: 12px;
  }
  
  .hero-auth-buttons {
    gap: 8px;
    flex-direction: column;
    width: 100%;
  }
  
  .auth-btn {
    width: 100%;
    justify-content: center;
  }
  
  .hero-stats {
    gap: 20px;
    flex-direction: column;
  }
  
  .stat-number {
    font-size: clamp(1.8rem, 4vw, 2rem);
  }
  
  .stat-label {
    font-size: clamp(0.75rem, 2vw, 0.8rem);
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
  
  .grid-list {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  
  .course-card,
  .testimonial-card {
    margin: 0 10px;
  }
}

@media (max-width: 360px) {
  .hero-title {
    font-size: clamp(1.6rem, 6vw, 1.8rem);
  }
  
  .hero-text {
    font-size: clamp(0.85rem, 3vw, 0.9rem);
  }
  
  .btn {
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
    font-size: clamp(0.8rem, 2.5vw, 0.85rem);
  }
  
  .stat-number {
    font-size: clamp(1.6rem, 4vw, 1.8rem);
  }
  
  .hero-stats {
    gap: 15px;
  }
  
  .hero-actions {
    gap: 10px;
  }
}
</style>
