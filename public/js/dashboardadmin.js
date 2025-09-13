document.addEventListener("DOMContentLoaded", () => {
  // Navigation functionality
  const navItems = document.querySelectorAll(".nav-item")

  navItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault()

      // Remove active class from all items
      navItems.forEach((nav) => nav.classList.remove("active"))

      // Add active class to clicked item
      this.classList.add("active")
    })
  })

  // Animated counter for stats
  function animateCounter(element, target, duration = 2000) {
    const start = 0
    const increment = target / (duration / 16)
    let current = start

    const timer = setInterval(() => {
      current += increment
      if (current >= target) {
        current = target
        clearInterval(timer)
      }

      if (target >= 1000000) {
        element.textContent = `Rp ${Math.floor(current).toLocaleString("id-ID")}`
      } else {
        element.textContent = Math.floor(current).toLocaleString("id-ID")
      }
    }, 16)
  }

  // Animate stats on page load
  const statValues = document.querySelectorAll(".stat-value")
  statValues.forEach((stat) => {
    const target = Number.parseInt(stat.dataset.value)
    if (target) {
      animateCounter(stat, target)
    }
  })

  // Logout functionality
  const logoutBtn = document.querySelector(".logout-btn")
  logoutBtn.addEventListener("click", function () {
    if (confirm("Apakah Anda yakin ingin logout?")) {
      // Add logout animation
      this.style.transform = "scale(0.95)"
      setTimeout(() => {
        alert("Logout berhasil!")
        // In real app, redirect to login page
        // window.location.href = '/login';
      }, 150)
    }
  })

  // Button click animations
  const buttons = document.querySelectorAll("button, .nav-item a")
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      this.style.transform = "scale(0.98)"
      setTimeout(() => {
        this.style.transform = "scale(1)"
      }, 150)
    })
  })

  // Real-time updates simulation
  function updateTransactionTime() {
    const timeElements = document.querySelectorAll(".time")
    timeElements.forEach((element, index) => {
      const minutes = Math.floor(Math.random() * 10) + 1
      element.textContent = `${minutes} menit lalu`
    })
  }

  // Update transaction times every 30 seconds
  setInterval(updateTransactionTime, 30000)

  // Progress bar animation on scroll
  const progressBars = document.querySelectorAll(".progress-fill")
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const progressBar = entry.target
        const width = progressBar.style.width
        progressBar.style.width = "0%"
        setTimeout(() => {
          progressBar.style.width = width
        }, 100)
      }
    })
  })

  progressBars.forEach((bar) => {
    observer.observe(bar)
  })

  // Add hover effects to cards
  const cards = document.querySelectorAll(".stat-card, .transaction-item, .location-item")
  cards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-2px)"
      this.style.boxShadow = "0 4px 12px rgba(0, 0, 0, 0.15)"
    })

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)"
      this.style.boxShadow = "0 1px 3px rgba(0, 0, 0, 0.1)"
    })
  })

  // Animasi masuk untuk dashboard admin
  const main = document.querySelector("main")
  if (main) {
    main.classList.add("animate-fade-in-up-admin")
  }

  console.log("[v0] Admin dashboard loaded successfully")
})
