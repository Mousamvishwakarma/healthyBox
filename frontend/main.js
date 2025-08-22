// Contact Form submission
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const name = document.getElementById("name").value;
      const email = document.getElementById("email").value;
      const message = document.getElementById("message").value;
      const successMsg = document.getElementById("successMsg");

      fetch("http://localhost/healthybox-backend/contact.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, email, message })
      })
        .then(res => res.json())
        .then(data => {
          successMsg.innerText =
            data.status === "success"
              ? "✅ " + data.message
              : "❌ " + data.message;
          if (data.status === "success") form.reset();
        })
        .catch(() => {
          successMsg.innerText = "❌ Failed to connect. Try again.";
        });
    });
  }
});
