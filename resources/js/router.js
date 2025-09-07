import { createRouter, createWebHistory } from 'vue-router'
import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Courses from './pages/Courses.vue'
import Blog from './pages/Blog.vue'
import Contact from './pages/Contact.vue'
import Login from './pages/Login.vue'
import Signup from './pages/Signup.vue'
import Dashboard from './pages/Dashboard.vue'
import DashboardProf from './pages/DashboardProf.vue'
import AdminDashboard from './pages/AdminDashboard.vue'
import Profile from './pages/Profile.vue'
import CourseForm from './pages/CourseForm.vue'
import CourseChapters from './pages/CourseChapters.vue'
import ChapterLessons from './pages/ChapterLessons.vue'
import CourseStudents from './pages/CourseStudents.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
  {
    path: '/courses',
    name: 'Courses',
    component: Courses
  },
  {
    path: '/blog',
    name: 'Blog',
    component: Blog
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/signup',
    name: 'Signup',
    component: Signup
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard
  },
  {
    path: '/instructor/dashboard',
    name: 'DashboardProf',
    component: DashboardProf
  },
  {
    path: '/admin/dashboard',
    name: 'AdminDashboard',
    component: AdminDashboard
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile
  },
  // Course Management Routes
  {
    path: '/instructor/courses/create',
    name: 'CreateCourse',
    component: CourseForm
  },
  {
    path: '/instructor/courses/:courseId/edit',
    name: 'EditCourse',
    component: CourseForm
  },
  {
    path: '/instructor/courses/:courseId/chapters',
    name: 'CourseChapters',
    component: CourseChapters
  },
  {
    path: '/instructor/chapters/:chapterId/lessons',
    name: 'ChapterLessons',
    component: ChapterLessons
  },
  {
    path: '/instructor/courses/:courseId/students',
    name: 'CourseStudents',
    component: CourseStudents
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guard pour vérifier l'authentification
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const user = localStorage.getItem('user')
  
  // Routes protégées
  if (to.path === '/dashboard' || to.path === '/profile' || 
      to.path.startsWith('/instructor/')) {
    if (!token || !user) {
      next('/login')
      return
    }
  }
  
  // Si déjà connecté et essaie d'accéder à login/signup
  if ((to.path === '/login' || to.path === '/signup') && token && user) {
    // Redirect based on user role
    const userData = JSON.parse(user)
    if (userData.role === 'instructor') {
      next('/instructor/dashboard')
    } else if (userData.role === 'admin') {
      next('/admin/dashboard')
    } else {
      next('/dashboard')
    }
    return
  }
  
  // Role-based access control for dashboard
  if (to.path === '/dashboard' && token && user) {
    const userData = JSON.parse(user)
    if (userData.role === 'instructor') {
      next('/instructor/dashboard')
      return
    } else if (userData.role === 'admin') {
      next('/admin/dashboard')
      return
    }
  }
  
  next()
})

export default router
