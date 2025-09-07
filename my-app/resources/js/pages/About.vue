<template>
  <main>
    <!-- About Hero Section -->
    <section class="hero about-hero" aria-label="about hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="h1 hero-title">
            About <span class="span">EduWeb</span>
          </h1>
          <p class="hero-text">
            We are passionate about democratizing education and making quality learning accessible to everyone, everywhere. Our mission is to empower individuals to achieve their full potential through innovative online education.
          </p>
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
        <figure class="hero-banner">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="about hero banner" class="w-100">
        </figure>
      </div>
    </section>

    <!-- Our Story Section -->
    <section class="section our-story" aria-label="our story">
      <div class="container">
        <div class="story-grid">
          <div class="story-content">
            <h2 class="h2 section-title">
              Our <span class="span">Story</span>
            </h2>
            <p class="story-text">
              Founded in 2014, EduWeb began with a simple vision: to make quality education accessible to everyone, regardless of their location or background. What started as a small platform with just a handful of courses has grown into a global learning community.
            </p>
            <p class="story-text">
              Today, we serve over 50,000 students from more than 150 countries, offering courses in technology, business, design, and more. Our team of expert instructors and dedicated staff work tirelessly to create engaging, high-quality learning experiences that empower learners to succeed in their chosen fields.
            </p>
            <div class="story-features">
              <div class="feature-item">
                <ion-icon name="checkmark-circle" aria-hidden="true"></ion-icon>
                <span>10+ Years of Excellence</span>
              </div>
              <div class="feature-item">
                <ion-icon name="checkmark-circle" aria-hidden="true"></ion-icon>
                <span>Global Learning Community</span>
              </div>
              <div class="feature-item">
                <ion-icon name="checkmark-circle" aria-hidden="true"></ion-icon>
                <span>Industry-Recognized Certificates</span>
              </div>
            </div>
          </div>
          <div class="story-image">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Our Story" class="w-100">
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="section stats" aria-label="statistics">
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

    <!-- Mission & Vision Section -->
    <section class="section mission-vision" aria-label="mission and vision">
      <div class="container">
        <div class="section-header">
          <h2 class="h2 section-title">
            Our <span class="span">Mission & Vision</span>
          </h2>
          <p class="section-text">
            We're driven by a clear purpose and an ambitious vision for the future of education
          </p>
        </div>
        <div class="mv-grid">
          <div class="mv-card">
            <div class="mv-icon">
              <ion-icon name="flag-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">Our Mission</h3>
            <p class="mv-text">
              To provide accessible, high-quality education that empowers individuals to achieve their full potential and contribute positively to society. We believe that education should be a right, not a privilege.
            </p>
          </div>
          <div class="mv-card">
            <div class="mv-icon">
              <ion-icon name="eye-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">Our Vision</h3>
            <p class="mv-text">
              To become the leading platform for online education, fostering a global community of lifelong learners and innovators who drive positive change in the world.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="section values" aria-label="our values">
      <div class="container">
        <div class="section-header">
          <h2 class="h2 section-title">
            Our <span class="span">Core Values</span>
          </h2>
          <p class="section-text">
            These principles guide everything we do and shape our culture
          </p>
        </div>
        <div class="values-grid">
          <div class="value-card" v-for="value in values" :key="value.id">
            <div class="value-icon">
              <ion-icon :name="value.icon" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">{{ value.title }}</h3>
            <p class="value-text">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Team Section -->
    <section class="section team" aria-label="our team">
      <div class="container">
        <div class="section-header">
          <h2 class="h2 section-title">
            Meet Our <span class="span">Leadership Team</span>
          </h2>
          <p class="section-text">
            The passionate individuals driving our mission forward
          </p>
        </div>
        <div class="team-grid">
          <div class="team-card" v-for="member in teamMembers" :key="member.id">
            <div class="team-image">
              <img :src="member.image" :alt="member.name" class="w-100">
            </div>
            <div class="team-content">
              <h3 class="team-name">{{ member.name }}</h3>
              <p class="team-role">{{ member.position }}</p>
              <p class="team-bio">{{ member.bio }}</p>
              <div class="team-social">
                <a href="#" class="social-link">
                  <ion-icon name="logo-linkedin" aria-hidden="true"></ion-icon>
                </a>
                <a href="#" class="social-link">
                  <ion-icon name="logo-twitter" aria-hidden="true"></ion-icon>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta" aria-label="call to action">
      <div class="container">
        <div class="cta-content">
          <h2 class="h2 cta-title">
            Join Our <span class="span">Learning Community</span>
          </h2>
          <p class="cta-text">
            Be part of our mission to democratize education and help shape the future of learning
          </p>
          <div class="cta-actions">
            <router-link to="/courses" class="btn btn-primary">
              <span class="span">Explore Courses</span>
              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </router-link>
            <router-link to="/contact" class="btn btn-outline">
              <span class="span">Get in Touch</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'About',
  data() {
    return {
      stats: [
        {
          id: 1,
          icon: 'people-outline',
          value: '50K+',
          label: 'Students Enrolled'
        },
        {
          id: 2,
          icon: 'school-outline',
          value: '200+',
          label: 'Expert Instructors'
        },
        {
          id: 3,
          icon: 'library-outline',
          value: '500+',
          label: 'Courses Available'
        },
        {
          id: 4,
          icon: 'globe-outline',
          value: '150+',
          label: 'Countries Reached'
        }
      ],
      values: [
        {
          id: 1,
          icon: 'heart-outline',
          title: 'Passion for Learning',
          description: 'We believe in the transformative power of education and are passionate about helping others learn and grow.'
        },
        {
          id: 2,
          icon: 'diamond-outline',
          title: 'Quality First',
          description: 'We maintain the highest standards in our course content, instruction, and learning experience.'
        },
        {
          id: 3,
          icon: 'people-circle-outline',
          title: 'Community Focus',
          description: 'We foster a supportive learning community where students can connect, collaborate, and grow together.'
        },
        {
          id: 4,
          icon: 'bulb-outline',
          title: 'Innovation',
          description: 'We continuously innovate our platform and teaching methods to provide the best learning experience.'
        },
        {
          id: 5,
          icon: 'accessibility-outline',
          title: 'Accessibility',
          description: 'We believe education should be accessible to everyone, regardless of their background or location.'
        },
        {
          id: 6,
          icon: 'trending-up-outline',
          title: 'Continuous Growth',
          description: 'We encourage and support continuous learning and personal development for all our community members.'
        }
      ],
      teamMembers: [
        {
          id: 1,
          name: 'Dr. Sarah Johnson',
          position: 'CEO & Founder',
          bio: 'Education expert with 15+ years in online learning and curriculum development. Former professor at Stanford University.',
          image: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'
        },
        {
          id: 2,
          name: 'Michael Chen',
          position: 'CTO',
          bio: 'Technology leader passionate about creating innovative learning platforms. Previously led engineering teams at Google and Microsoft.',
          image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'
        },
        {
          id: 3,
          name: 'Emily Rodriguez',
          position: 'Head of Content',
          bio: 'Curriculum specialist dedicated to creating engaging educational experiences. Expert in instructional design and learning psychology.',
          image: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80'
        },
        {
          id: 4,
          name: 'David Thompson',
          position: 'Lead Instructor',
          bio: 'Experienced educator with expertise in multiple programming languages. Has helped thousands of students transition into tech careers.',
          image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80'
        }
      ]
    }
  }
}
</script>

<style scoped>
.about-hero {
  padding: 120px 0 80px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.about-hero .container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.about-hero .hero-banner {
  display: flex;
  justify-content: center;
  align-items: center;
}

.about-hero .hero-banner img {
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
  opacity: 0.9;
  max-width: 500px;
}

.our-story {
  padding: 100px 0;
}

.story-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.story-content h2 {
  margin-bottom: 30px;
  color: var(--eerie-black-1);
}

.story-text {
  font-size: 1.1rem;
  line-height: 1.7;
  color: var(--gray-web);
  margin-bottom: 20px;
}

.story-features {
  margin-top: 30px;
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
  color: var(--eerie-black-1);
  font-weight: 500;
}

.feature-item ion-icon {
  color: var(--kappel);
  font-size: 1.2rem;
}

.story-image img {
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto;
  object-fit: cover;
  aspect-ratio: 4/3;
  min-height: 400px;
}

.stats {
  padding: 80px 0;
  background: var(--isabelline);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}

.stat-card {
  text-align: center;
  padding: 40px 30px;
  background: white;
  border-radius: 15px;
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

.mission-vision {
  padding: 100px 0;
}

.section-header {
  text-align: center;
  margin-bottom: 60px;
}

.section-text {
  font-size: 1.1rem;
  color: var(--gray-web);
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

.mv-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.mv-card {
  padding: 40px;
  background: white;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.mv-icon {
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

.mv-text {
  color: var(--gray-web);
  line-height: 1.6;
}

.values {
  padding: 100px 0;
  background: var(--isabelline);
}

.values-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}

.value-card {
  background: white;
  padding: 40px 30px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.value-card:hover {
  transform: translateY(-5px);
}

.value-icon {
  width: 70px;
  height: 70px;
  margin: 0 auto 20px;
  background: var(--kappel);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.8rem;
}

.value-card h3 {
  margin-bottom: 15px;
  color: var(--eerie-black-1);
}

.value-text {
  color: var(--gray-web);
  line-height: 1.6;
}

.team {
  padding: 100px 0;
}

.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
}

.team-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.team-card:hover {
  transform: translateY(-5px);
}

.team-image {
  width: 100%;
  height: 250px;
  overflow: hidden;
}

.team-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.team-content {
  padding: 25px;
  text-align: center;
}

.team-name {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--eerie-black-1);
  margin-bottom: 5px;
}

.team-role {
  color: var(--kappel);
  font-weight: 500;
  margin-bottom: 15px;
}

.team-bio {
  color: var(--gray-web);
  line-height: 1.6;
  margin-bottom: 20px;
}

.team-social {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.social-link {
  width: 40px;
  height: 40px;
  background: var(--isabelline);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--kappel);
  text-decoration: none;
  transition: all 0.3s ease;
}

.social-link:hover {
  background: var(--kappel);
  color: white;
  transform: translateY(-3px);
}

.cta {
  padding: 100px 0;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  text-align: center;
}

.cta h2 {
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.cta p {
  font-size: 1.2rem;
  margin-bottom: 40px;
  opacity: 0.9;
}

.cta-actions {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 15px 30px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  font-size: 1rem;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  cursor: pointer;
}

.btn-primary {
  background: white;
  color: var(--kappel);
  border-color: white;
}

.btn-primary:hover {
  background: transparent;
  color: white;
  border-color: white;
  transform: translateY(-2px);
}

.btn-outline {
  background: transparent;
  color: white;
  border-color: white;
}

.btn-outline:hover {
  background: white;
  color: var(--kappel);
  transform: translateY(-2px);
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

/* Responsive Design */
@media (max-width: 1024px) {
  .hero-title {
    font-size: 3rem;
  }
  
  .hero-text {
    font-size: 1.1rem;
  }
  
  .story-grid,
  .mv-grid {
    gap: 40px;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2.5rem;
    text-align: center;
  }
  
  .hero-text {
    font-size: 1rem;
    text-align: center;
  }
  
  .hero-auth-buttons {
    justify-content: center;
    gap: 10px;
  }
  
  .story-grid,
  .mv-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }
  
  .values-grid {
    grid-template-columns: 1fr;
  }
  
  .team-grid {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }
  
  .cta h2 {
    font-size: 2rem;
  }
  
  .cta-actions {
    flex-direction: column;
    align-items: center;
  }
}

@media (max-width: 480px) {
  .hero-title {
    font-size: 2rem;
    line-height: 1.3;
  }
  
  .hero-text {
    font-size: 0.95rem;
    line-height: 1.5;
  }
  
  .about-hero .hero-banner img {
    max-height: 400px;
    min-height: 350px;
  }
  
  .story-image img {
    min-height: 300px;
  }
  
  .hero-auth-buttons {
    flex-direction: column;
    width: 100%;
  }
  
  .auth-btn {
    width: 100%;
    justify-content: center;
  }
  
  .stat-number {
    font-size: 2rem;
  }
  
  .cta h2 {
    font-size: 1.8rem;
  }
  
  .cta p {
    font-size: 0.95rem;
  }
  
  .btn {
    padding: 12px 20px;
    font-size: 0.9rem;
  }
  
  .section-title {
    font-size: 1.8rem;
  }
  
  .section-text {
    font-size: 0.95rem;
  }
}

@media (max-width: 360px) {
  .hero-title {
    font-size: 1.8rem;
  }
  
  .hero-text {
    font-size: 0.9rem;
  }
  
  .btn {
    padding: 10px 16px;
    font-size: 0.85rem;
  }
}
</style>
