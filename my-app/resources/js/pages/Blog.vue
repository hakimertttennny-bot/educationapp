<template>
  <main>
    <!-- Blog Hero Section -->
    <section class="hero blog-hero" aria-label="blog hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="h1 hero-title">
            Our <span class="span">Blog</span>
          </h1>
          <p class="hero-text">
            Stay updated with the latest insights, tips, and trends in education and technology. Our blog features expert articles, tutorials, and industry news.
          </p>
        </div>
        <figure class="hero-banner">
          <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="blog hero banner" class="w-100">
        </figure>
      </div>
    </section>

    <!-- Featured Blog Post -->
    <section class="section featured-post" aria-label="featured post">
      <div class="container">
        <div class="featured-post-card">
          <figure class="card-banner">
            <img :src="featuredPost.image" width="800" height="400" loading="lazy" :alt="featuredPost.title" class="img-cover">
          </figure>
          <div class="card-content">
            <div class="card-meta">
              <time class="time" :datetime="featuredPost.date">{{ featuredPost.date }}</time>
              <span class="span">{{ featuredPost.category }}</span>
              <span class="author">By {{ featuredPost.author }}</span>
            </div>
            <h2 class="h2">
              <a href="#" class="card-title">{{ featuredPost.title }}</a>
            </h2>
            <p class="card-text">{{ featuredPost.excerpt }}</p>
            <a href="#" class="btn has-before">
              <span class="span">Read More</span>
              <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Blog Posts Section -->
    <section class="section blog-posts" aria-label="blog posts">
      <div class="container">
        <div class="blog-header">
          <h2 class="h2 section-title">Latest Articles</h2>
          <div class="blog-filter">
            <select v-model="selectedCategory" class="filter-select">
              <option value="">All Categories</option>
              <option v-for="category in categories" :key="category" :value="category">
                {{ category }}
              </option>
            </select>
          </div>
        </div>
        <ul class="grid-list">
          <li v-for="post in filteredPosts" :key="post.id">
            <div class="blog-card">
              <figure class="card-banner">
                <img :src="post.image" width="370" height="270" loading="lazy" :alt="post.title" class="img-cover">
              </figure>
              <div class="card-content">
                <div class="card-meta">
                  <time class="time" :datetime="post.date">{{ post.date }}</time>
                  <span class="span">{{ post.category }}</span>
                </div>
                <h3 class="h3">
                  <a href="#" class="card-title">{{ post.title }}</a>
                </h3>
                <p class="card-text">{{ post.excerpt }}</p>
                <div class="post-meta">
                  <span class="author">By {{ post.author }}</span>
                  <span class="read-time">{{ post.readTime }} min read</span>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <!-- Newsletter Section -->
    <section class="section newsletter" aria-label="newsletter">
      <div class="container">
        <div class="newsletter-content">
          <h2 class="h2 section-title">
            Subscribe to Our <span class="span">Newsletter</span>
          </h2>
          <p class="section-text">
            Get the latest articles, tips, and updates delivered directly to your inbox. Stay ahead of the curve with our expert insights.
          </p>
          <form class="newsletter-form" @submit.prevent="subscribeNewsletter">
            <input 
              type="email" 
              v-model="newsletterEmail" 
              name="email" 
              placeholder="Enter your email address" 
              class="newsletter-field"
              required
            >
            <button type="submit" class="newsletter-submit" aria-label="Submit newsletter">
              <ion-icon name="paper-plane" aria-hidden="true"></ion-icon>
            </button>
          </form>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'Blog',
  data() {
    return {
      newsletterEmail: '',
      selectedCategory: '',
      categories: ['Education', 'Technology', 'Self-Development', 'Career Tips', 'Industry News'],
      featuredPost: {
        id: 1,
        title: 'The Future of Online Education: Trends to Watch in 2024',
        excerpt: 'Discover the latest trends shaping the future of online education, from AI-powered learning to virtual reality classrooms and personalized learning experiences.',
        image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        date: '2024-01-20',
        category: 'Education',
        author: 'Dr. Sarah Johnson',
        readTime: 8
      },
      blogPosts: [
        {
          id: 2,
          title: 'Top Programming Languages to Learn in 2024',
          excerpt: 'Explore the most in-demand programming languages that will dominate the tech industry this year and beyond.',
          image: 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          date: '2024-01-18',
          category: 'Technology',
          author: 'Michael Chen',
          readTime: 6
        },
        {
          id: 3,
          title: 'How to Stay Motivated While Learning Online',
          excerpt: 'Practical strategies and tips to maintain motivation and achieve your learning goals in an online environment.',
          image: 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          date: '2024-01-15',
          category: 'Self-Development',
          author: 'Emily Rodriguez',
          readTime: 5
        },
        {
          id: 4,
          title: 'Building a Successful Career in Tech: A Complete Guide',
          excerpt: 'Comprehensive guide to building a successful career in technology, from choosing the right path to landing your dream job.',
          image: 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          date: '2024-01-12',
          category: 'Career Tips',
          author: 'David Thompson',
          readTime: 10
        },
        {
          id: 5,
          title: 'The Rise of AI in Education: Opportunities and Challenges',
          excerpt: 'Understanding how artificial intelligence is transforming education and what it means for students and educators.',
          image: 'https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          date: '2024-01-10',
          category: 'Technology',
          author: 'Dr. Sarah Johnson',
          readTime: 7
        },
        {
          id: 6,
          title: 'Effective Study Techniques for Online Learning',
          excerpt: 'Proven study techniques and strategies specifically designed for online learning environments.',
          image: 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          date: '2024-01-08',
          category: 'Education',
          author: 'Emily Rodriguez',
          readTime: 6
        },
        {
          id: 7,
          title: 'Industry Insights: What Employers Look for in 2024',
          excerpt: 'Stay ahead of the competition by understanding what skills and qualities employers are seeking in today\'s job market.',
          image: 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
          date: '2024-01-05',
          category: 'Industry News',
          author: 'Michael Chen',
          readTime: 8
        }
      ]
    }
  },
  computed: {
    filteredPosts() {
      if (!this.selectedCategory) {
        return this.blogPosts;
      }
      return this.blogPosts.filter(post => post.category === this.selectedCategory);
    }
  },
  methods: {
    subscribeNewsletter() {
      console.log('Subscribing email:', this.newsletterEmail);
      // Add your newsletter subscription logic here
      this.newsletterEmail = '';
      // Show success message
      alert('Thank you for subscribing to our newsletter!');
    }
  }
}
</script>

<style scoped>
.blog-hero {
  padding: 120px 0 80px;
  background: linear-gradient(135deg, var(--kappel) 0%, var(--selective-yellow) 100%);
  color: white;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.blog-hero .container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.blog-hero .hero-banner {
  display: flex;
  justify-content: center;
  align-items: center;
}

.blog-hero .hero-banner img {
  max-width: 100%;
  height: auto;
  border-radius: 15px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
  object-fit: cover;
  aspect-ratio: 1/1;
  max-height: 400px;
}

.blog-hero .hero-title {
  font-size: clamp(2rem, 5vw, 3.5rem);
  line-height: 1.2;
  margin-bottom: 20px;
  font-weight: 700;
}

.blog-hero .hero-text {
  font-size: clamp(1rem, 2.5vw, 1.2rem);
  line-height: 1.6;
  margin-bottom: 30px;
  opacity: 0.9;
  max-width: 500px;
}

.featured-post {
  padding: 80px 0;
}

.featured-post-card {
  background: var(--white);
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.featured-post-card .card-banner img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 15px 15px 0 0;
}

.featured-post-card .card-content {
  padding: 40px;
}

.featured-post-card .card-title {
  font-size: 2rem;
  margin: 20px 0;
  color: var(--text-color);
  text-decoration: none;
}

.featured-post-card .card-title:hover {
  color: var(--primary-color);
}

.blog-posts {
  padding: 80px 0;
  background: var(--light-bg);
}

.blog-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
  flex-wrap: wrap;
  gap: 20px;
}

.blog-filter {
  display: flex;
  gap: 15px;
}

.filter-select {
  padding: 10px 15px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  background: var(--white);
  color: var(--text-color);
  font-size: 0.9rem;
  cursor: pointer;
}

.filter-select:focus {
  outline: none;
  border-color: var(--primary-color);
}

.blog-card {
  background: var(--white);
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.blog-card .card-banner img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 15px 15px 0 0;
}

.blog-card:hover {
  transform: translateY(-5px);
}

.blog-card .card-content {
  padding: 30px;
}

.blog-card .card-title {
  color: var(--text-color);
  text-decoration: none;
  margin: 15px 0;
  display: block;
}

.blog-card .card-title:hover {
  color: var(--primary-color);
}

.post-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--border-color);
  font-size: 0.9rem;
  color: var(--text-light);
}

.newsletter {
  padding: 80px 0;
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  color: white;
  text-align: center;
}

.newsletter-content {
  max-width: 600px;
  margin: 0 auto;
}

.newsletter-form {
  display: flex;
  gap: 15px;
  margin-top: 30px;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

.newsletter-field {
  flex: 1;
  padding: 15px 20px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
}

.newsletter-field:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

.newsletter-submit {
  padding: 15px 20px;
  background: var(--white);
  color: var(--primary-color);
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.newsletter-submit:hover {
  background: var(--light-bg);
}

/* Responsive Design */
@media (max-width: 1200px) {
  .blog-hero .container {
    gap: 40px;
  }
  
  .blog-hero .hero-title {
    font-size: clamp(2.5rem, 4vw, 3rem);
  }
  
  .blog-hero .hero-text {
    font-size: clamp(1rem, 2vw, 1.1rem);
  }
}

@media (max-width: 1024px) {
  .blog-hero {
    padding: 100px 0 60px;
    min-height: auto;
  }
  
  .blog-hero .container {
    grid-template-columns: 1fr;
    gap: 40px;
    text-align: center;
  }
  
  .blog-hero .hero-banner {
    order: -1;
  }
  
  .blog-hero .hero-text {
    max-width: 100%;
    margin: 0 auto 30px;
  }
  
  .blog-grid {
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  }
}

@media (max-width: 768px) {
  .blog-hero {
    padding: 80px 0 50px;
  }
  
  .blog-hero .hero-title {
    font-size: clamp(2rem, 5vw, 2.5rem);
  }
  
  .blog-hero .hero-text {
    font-size: clamp(0.95rem, 2.5vw, 1rem);
  }
  
  .blog-header {
    flex-direction: column;
    align-items: stretch;
  }
  
  .blog-filter {
    justify-content: center;
  }
  
  .newsletter-form {
    flex-direction: column;
  }
  
  .featured-post-card .card-title {
    font-size: clamp(1.4rem, 3vw, 1.5rem);
  }
  
  .blog-grid {
    grid-template-columns: 1fr;
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
  .blog-hero {
    padding: 60px 0 40px;
  }
  
  .blog-hero .hero-title {
    font-size: clamp(1.8rem, 6vw, 2rem);
    line-height: 1.3;
  }
  
  .blog-hero .hero-text {
    font-size: clamp(0.9rem, 3vw, 0.95rem);
    line-height: 1.5;
  }
  
  .blog-hero .hero-banner img {
    max-height: 300px;
  }
  
  .featured-post-card .card-banner img {
    height: 200px;
  }
  
  .blog-card .card-banner img {
    height: 150px;
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
  
  .blog-grid {
    gap: 20px;
  }
  
  .blog-card,
  .featured-post-card {
    margin: 0 10px;
  }
  
  .featured-post-card .card-content {
    padding: clamp(20px, 5vw, 30px);
  }
  
  .blog-card .card-content {
    padding: clamp(20px, 5vw, 30px);
  }
}

@media (max-width: 360px) {
  .blog-hero .hero-title {
    font-size: clamp(1.6rem, 6vw, 1.8rem);
  }
  
  .blog-hero .hero-text {
    font-size: clamp(0.85rem, 3vw, 0.9rem);
  }
  
  .btn {
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
    font-size: clamp(0.8rem, 2.5vw, 0.85rem);
  }
  
  .featured-post-card .card-title {
    font-size: clamp(1.2rem, 3vw, 1.4rem);
  }
}
</style>
