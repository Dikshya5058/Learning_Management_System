// 1. Admin Credentials
const ADMIN = { email: "admin@lms.com", password: "admin123" };

// 2. Login Function
function login() {
  const email = document.getElementById("loginEmail").value.trim();
  const password = document.getElementById("loginPassword").value;
  const error = document.getElementById("loginError");

  if (email === ADMIN.email && password === ADMIN.password) {
    // Switch views
    document.getElementById("loginPage").style.display = "none";
    document.getElementById("dashboard").style.display = "block";
    error.textContent = "";
  } else {
    error.textContent = "Wrong email or password.";
    document.getElementById("loginPassword").value = ""; // Clear password on fail
  }
}

// 3. Logout Function
function logout() {
  document.getElementById("dashboard").style.display = "none";
  document.getElementById("loginPage").style.display = "flex";
  document.getElementById("loginPassword").value = "";
  document.getElementById("loginEmail").value = "";
}

// 4. Global Event: Press Enter to Login
document.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    const loginPage = document.getElementById("loginPage");
    // Only trigger login if the login page is currently visible
    if (window.getComputedStyle(loginPage).display !== "none") {
      login();
    }
  }
});