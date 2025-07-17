async function requestOTP() {
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();

  if (!username || !email) {
    alert("Please enter username and email.");
    return;
  }

  try {
    const res = await fetch("../logic/auth.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        action: "request_code",
        username,
        email
      })
    });

    const data = await res.json();
    if (data.message && data.message.includes("OTP")) {
      alert("OTP sent successfully!");
    } else {
      alert(data.message || "Failed to send OTP.");
    }
  } catch (e) {
    console.error(e);
    alert("Error sending OTP.");
  }
}

async function verifyOTP() {
  const email = document.getElementById("email").value.trim();
  const code = document.getElementById("otp").value.trim();

  if (!email || !code) {
    alert("Enter email and OTP code.");
    return;
  }

  try {
    const res = await fetch("../logic/auth.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        action: "verify_code",
        email,
        code
      })
    });

    const data = await res.json();
    if (data.valid === true) {
      alert("OTP verified. Proceeding with registration...");
      // Here you can call your register logic (regUsers.php) to complete registration
    } else {
      alert(data.message || "Invalid or expired OTP.");
    }
  } catch (e) {
    console.error(e);
    alert("Error verifying OTP.");
  }
}
