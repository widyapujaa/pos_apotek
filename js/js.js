function showAlert(icon, title, message, redirectUrl) {
  Swal.fire({
    icon: icon,
    title: title,
    text: message,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = redirectUrl;
    }
  });
}

function showConfirm(icon, title, message, redirectUrl) {
  Swal.fire({
    icon: icon,
    title: title,
    text: message,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Batal",
    confirmButtonText: "Yakin",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = redirectUrl;
    }
  });
}
