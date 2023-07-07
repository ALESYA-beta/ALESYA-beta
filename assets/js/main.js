function updateKecepatanInternet() {
  if ("connection" in navigator && "downlink" in navigator.connection) {
    var kecepatan = navigator.connection.downlink * 1024; // Mengonversi ke kbps

    var kecepatanFormatted;
    if (kecepatan >= 1000000) {
      kecepatanFormatted = (kecepatan / 1000000).toFixed(2) + " mbps";
    } else {
      kecepatanFormatted = (kecepatan / 1000).toFixed(2) + " kbps";
    }

    var kecepatanElement = document.getElementById("kecepatan-internet");
    kecepatanElement.textContent = kecepatanFormatted;
  } else {
    var kecepatanElement = document.getElementById("kecepatan-internet");
    kecepatanElement.textContent = "Tidak dapat mendeteksi kecepatan internet.";
  }
}

// Memperbarui kecepatan internet setiap 1 detik
setInterval(updateKecepatanInternet, 1000);

// ping
function ping(url, callback) {
  var start = new Date().getTime();
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      var end = new Date().getTime();
      var duration = end - start;
      callback(null, duration);
    }
  };

  xhr.onerror = function() {
    callback(new Error("Error in making the request."));
  };

  xhr.open("GET", url, true);
  xhr.send();
}

function pingUrl() {
  var url = "http://localhost:7700/index.html"; // Ganti dengan URL yang ingin Anda ping
  var resultElement = document.getElementById("result");
  resultElement.textContent = "Pinging...";

  ping(url, function(error, duration) {
    if (error) {
      resultElement.textContent = "Ping error: " + error.message;
    } else {
      resultElement.textContent = "Ping : " + duration + " ms";
    }
  });
}

window.onload = function() {
  pingUrl(); // Memanggil fungsi pingUrl saat halaman selesai dimuat
  setInterval(pingUrl, 5000); // Memanggil fungsi pingUrl setiap 5 detik
};

if ("connection" in navigator && "effectiveType" in navigator.connection) {
  //console.log("Nama jaringan: " + navigator.connection.effectiveType);
  document.getElementById('modeljangan').innerHTML = navigator.connection.effectiveType;
} else {
  console.log("Tidak dapat mendeteksi nama jaringan.");
}