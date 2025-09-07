<template>
  <main>
    <!-- Contact Hero Section -->
    <section class="hero contact-hero" aria-label="contact hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="h1 hero-title">
            Get in <span class="span">Touch</span>
          </h1>
          <p class="hero-text">
            Have questions about our courses or need support? We're here to help! Reach out to us through any of the channels below.
          </p>
        </div>
        <figure class="hero-banner">
          <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="contact hero banner" class="w-100">
        </figure>
      </div>
    </section>

    <!-- Contact Information Section -->
    <section class="section contact-info" aria-label="contact information">
      <div class="container">
        <div class="contact-grid">
          <div class="contact-card">
            <div class="card-icon">
              <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">Our Location</h3>
            <p class="card-text">Rue Hassan II, Medina<br>Tetouan, Tétouan Province<br>Morocco</p>
          </div>
          <div class="contact-card">
            <div class="card-icon">
              <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">Phone Number</h3>
            <p class="card-text">
              <a href="tel:+1-555-123-4567">+1 (555) 123-4567</a><br>
              <a href="tel:+1-555-987-6543">+1 (555) 987-6543</a>
            </p>
          </div>
          <div class="contact-card">
            <div class="card-icon">
              <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">Email Address</h3>
            <p class="card-text">
              <a href="mailto:info@eduweb.com">info@eduweb.com</a><br>
              <a href="mailto:support@eduweb.com">support@eduweb.com</a>
            </p>
          </div>
          <div class="contact-card">
            <div class="card-icon">
              <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
            </div>
            <h3 class="h3">Working Hours</h3>
            <p class="card-text">
              Monday - Friday: 9:00 AM - 6:00 PM<br>
              Saturday: 10:00 AM - 4:00 PM<br>
              Sunday: Closed
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Form Section -->
    <section class="section contact-form" aria-label="contact form">
      <div class="container">
        <div class="form-container">
          <div class="form-header">
            <h2 class="h2 section-title">Send us a <span class="span">Message</span></h2>
            <p class="section-text">
              Fill out the form below and we'll get back to you as soon as possible. We typically respond within 24 hours.
            </p>
          </div>
          <form class="contact-form-element" @submit.prevent="submitForm">
            <div class="form-group">
              <label for="name" class="form-label">Full Name *</label>
              <input 
                type="text" 
                id="name" 
                v-model="formData.name" 
                name="name" 
                class="form-input" 
                required
              >
            </div>
            <div class="form-group">
              <label for="email" class="form-label">Email Address *</label>
              <input 
                type="email" 
                id="email" 
                v-model="formData.email" 
                name="email" 
                class="form-input" 
                required
              >
            </div>
            <div class="form-group">
              <label for="phone" class="form-label">Phone Number</label>
              <input 
                type="tel" 
                id="phone" 
                v-model="formData.phone" 
                name="phone" 
                class="form-input"
              >
            </div>
            <div class="form-group">
              <label for="subject" class="form-label">Subject *</label>
              <select 
                id="subject" 
                v-model="formData.subject" 
                name="subject" 
                class="form-select" 
                required
              >
                <option value="">Select a subject</option>
                <option value="general">General Inquiry</option>
                <option value="courses">Course Information</option>
                <option value="support">Technical Support</option>
                <option value="billing">Billing Question</option>
                <option value="partnership">Partnership</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group full-width">
              <label for="message" class="form-label">Message *</label>
              <textarea 
                id="message" 
                v-model="formData.message" 
                name="message" 
                class="form-textarea" 
                rows="6" 
                required
              ></textarea>
            </div>
            <button type="submit" class="btn has-before" :disabled="isSubmitting">
              <span class="span">{{ isSubmitting ? 'Sending...' : 'Send Message' }}</span>
              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="section faq" aria-label="frequently asked questions">
      <div class="container">
        <p class="section-subtitle">FAQ</p>
        <h2 class="h2 section-title">
          Frequently Asked <span class="span">Questions</span>
        </h2>
        <div class="faq-list">
          <div 
            v-for="(faq, index) in faqs" 
            :key="index" 
            class="faq-item"
            :class="{ 'active': activeFaq === index }"
          >
            <button class="faq-question" @click="toggleFaq(index)">
              <span class="question-text">{{ faq.question }}</span>
              <ion-icon 
                :name="activeFaq === index ? 'remove-outline' : 'add-outline'" 
                aria-hidden="true"
              ></ion-icon>
            </button>
            <div class="faq-answer" v-show="activeFaq === index">
              <p>{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Map Section -->
    <section class="section map-section" aria-label="map">
      <div class="container">
        <div class="map-container">
          <h2 class="h2 section-title">Find Us</h2>
          <div class="map-with-marker">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d102456.78901234567!2d-5.3698!3d35.5711!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b875cf04c132d%3A0x8c3c3c3c3c3c3c3c!2sMedina%20of%20Tetouan%2C%20Tetouan%2C%20Morocco!5e0!3m2!1sen!2sus!4v1234567890"
              width="100%" 
              height="400" 
              style="border:0; border-radius: 15px;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            <div class="willayat-marker">
              <div class="marker-icon">
                <ion-icon name="location" aria-hidden="true"></ion-icon>
              </div>
              <div class="marker-label">Willayat</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'Contact',
  data() {
    return {
      activeFaq: null,
      isSubmitting: false,
      formData: {
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: ''
      },
      faqs: [
        {
          question: 'How do I enroll in a course?',
          answer: 'You can enroll in any course by clicking the "Enroll Now" button on the course page. You\'ll be guided through the registration and payment process.'
        },
        {
          question: 'What payment methods do you accept?',
          answer: 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers. All payments are processed securely.'
        },
        {
          question: 'Can I get a refund if I\'m not satisfied?',
          answer: 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with your course, you can request a full refund within 30 days of purchase.'
        },
        {
          question: 'Do you offer certificates upon completion?',
          answer: 'Yes, all our courses provide a certificate of completion that you can download and share on your professional profiles.'
        },
        {
          question: 'How long do I have access to the course?',
          answer: 'You have lifetime access to all courses you purchase. You can revisit the content anytime and access updates and new materials.'
        },
        {
          question: 'Is there technical support available?',
          answer: 'Yes, we provide 24/7 technical support through our help center, email, and live chat during business hours.'
        }
      ]
    }
  },
  methods: {
    toggleFaq(index) {
      this.activeFaq = this.activeFaq === index ? null : index;
    },
    submitForm() {
      this.isSubmitting = true;
      
      // Simulate form submission
      setTimeout(() => {
        console.log('Form submitted:', this.formData);
        
        // Reset form
        this.formData = {
          name: '',
          email: '',
          phone: '',
          subject: '',
          message: ''
        };
        
        this.isSubmitting = false;
        
        // Show success message
        alert('Thank you for your message! We\'ll get back to you soon.');
      }, 2000);
    }
  }
}
</script>

<style scoped>
.contact-hero {
  padding: 120px 0 80px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.contact-hero .container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.contact-hero .hero-banner {
  display: flex;
  justify-content: center;
  align-items: center;
}

.contact-hero .hero-banner img {
  max-width: 100%;
  height: auto;
  border-radius: 15px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
  object-fit: cover;
  aspect-ratio: 1/1;
  max-height: 400px;
}

.contact-hero .hero-title {
  font-size: clamp(2rem, 5vw, 3.5rem);
  line-height: 1.2;
  margin-bottom: 20px;
  font-weight: 700;
}

.contact-hero .hero-text {
  font-size: clamp(1rem, 2.5vw, 1.2rem);
  line-height: 1.6;
  margin-bottom: 30px;
  opacity: 0.9;
  max-width: 500px;
}

.contact-info {
  padding: 80px 0;
}

.contact-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}

.contact-card {
  text-align: center;
  padding: 40px 30px;
  background: var(--white);
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.contact-card:hover {
  transform: translateY(-5px);
}

.contact-card .card-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  background: var(--primary-color);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.contact-card .card-icon ion-icon {
  font-size: 2rem;
  color: white;
}

.contact-card .card-text {
  color: var(--text-light);
  line-height: 1.6;
}

.contact-card .card-text a {
  color: var(--primary-color);
  text-decoration: none;
}

.contact-card .card-text a:hover {
  text-decoration: underline;
}

.contact-form {
  padding: 80px 0;
  background: var(--light-bg);
}

.form-container {
  max-width: 800px;
  margin: 0 auto;
  background: var(--white);
  padding: 50px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.form-header {
  text-align: center;
  margin-bottom: 40px;
}

.contact-form-element {
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

.form-label {
  margin-bottom: 8px;
  font-weight: 500;
  color: var(--text-color);
}

.form-input,
.form-select,
.form-textarea {
  padding: 12px 16px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: var(--primary-color);
}

.form-textarea {
  resize: vertical;
  min-height: 120px;
}

.contact-form-element .btn {
  grid-column: 1 / -1;
  justify-self: center;
  margin-top: 20px;
}

.faq {
  padding: 80px 0;
}

.faq-list {
  max-width: 800px;
  margin: 0 auto;
}

.faq-item {
  background: var(--white);
  border-radius: 10px;
  margin-bottom: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.faq-question {
  width: 100%;
  padding: 20px;
  background: none;
  border: none;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-size: 1.1rem;
  font-weight: 500;
  color: var(--text-color);
  transition: background-color 0.3s ease;
}

.faq-question:hover {
  background: var(--light-bg);
}

.faq-question ion-icon {
  font-size: 1.5rem;
  color: var(--primary-color);
  transition: transform 0.3s ease;
}

.faq-item.active .faq-question ion-icon {
  transform: rotate(45deg);
}

.faq-answer {
  padding: 0 20px 20px;
  color: var(--text-light);
  line-height: 1.6;
}

.map-section {
  padding: 80px 0;
  background: var(--light-bg);
}

.map-container {
  text-align: center;
}

.map-container iframe {
  margin-top: 30px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.map-with-marker {
  position: relative;
  margin-top: 30px;
}

.willayat-marker {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  background: var(--kappel);
  color: white;
  padding: 12px 16px;
  border-radius: 25px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 600;
  font-size: 0.9rem;
  animation: pulse 2s infinite;
}

.marker-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.marker-icon ion-icon {
  font-size: 1.2rem;
  color: white;
}

.marker-label {
  white-space: nowrap;
}

@keyframes pulse {
  0% {
    transform: translate(-50%, -50%) scale(1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  }
  50% {
    transform: translate(-50%, -50%) scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
  }
  100% {
    transform: translate(-50%, -50%) scale(1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  }
}

/* Responsive Design */
@media (max-width: 1200px) {
  .contact-hero .container {
    gap: 40px;
  }
  
  .contact-hero .hero-title {
    font-size: clamp(2.5rem, 4vw, 3rem);
  }
  
  .contact-hero .hero-text {
    font-size: clamp(1rem, 2vw, 1.1rem);
  }
}

@media (max-width: 1024px) {
  .contact-hero {
    padding: 100px 0 60px;
    min-height: auto;
  }
  
  .contact-hero .container {
    grid-template-columns: 1fr;
    gap: 40px;
    text-align: center;
  }
  
  .contact-hero .hero-banner {
    order: -1;
  }
  
  .contact-hero .hero-text {
    max-width: 100%;
    margin: 0 auto 30px;
  }
  
  .contact-grid {
    gap: 40px;
  }
}

@media (max-width: 768px) {
  .contact-hero {
    padding: 80px 0 50px;
  }
  
  .contact-hero .hero-title {
    font-size: clamp(2rem, 5vw, 2.5rem);
  }
  
  .contact-hero .hero-text {
    font-size: clamp(0.95rem, 2.5vw, 1rem);
  }
  
  .contact-form-element {
    grid-template-columns: 1fr;
  }
  
  .form-container {
    padding: 30px 20px;
  }
  
  .contact-grid {
    grid-template-columns: 1fr;
  }
  
  .contact-info {
    text-align: center;
  }
  
  .contact-item {
    justify-content: center;
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
  .contact-hero {
    padding: 60px 0 40px;
  }
  
  .contact-hero .hero-title {
    font-size: clamp(1.8rem, 6vw, 2rem);
    line-height: 1.3;
  }
  
  .contact-hero .hero-text {
    font-size: clamp(0.9rem, 3vw, 0.95rem);
    line-height: 1.5;
  }
  
  .contact-hero .hero-banner img {
    max-height: 300px;
  }
  
  .form-container {
    padding: clamp(15px, 4vw, 20px) clamp(12px, 3vw, 15px);
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
  
  .contact-grid {
    gap: 20px;
  }
  
  .contact-card {
    margin: 0 10px;
  }
  
  .form-container {
    margin: 0 10px;
  }
}

@media (max-width: 360px) {
  .contact-hero .hero-title {
    font-size: clamp(1.6rem, 6vw, 1.8rem);
  }
  
  .contact-hero .hero-text {
    font-size: clamp(0.85rem, 3vw, 0.9rem);
  }
  
  .btn {
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
    font-size: clamp(0.8rem, 2.5vw, 0.85rem);
  }
  
  .form-container {
    padding: clamp(12px, 3vw, 15px) clamp(10px, 2.5vw, 12px);
  }
}
</style>
