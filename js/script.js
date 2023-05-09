$(document).ready(() => {
  $("#file").on("change", function (e) {
    const files = e.target.files;
    if (files.length > 0) {
      $("#preview").attr("src", URL.createObjectURL(files[0]));
    }
  });

  $("#btn-submit").on("click", function (e) {
    const formData = new FormData();
    const alert = $("#alert");
    const name = $("#name").val();
    const email = $("#email").val();
    const files = $("#file")[0].files;

    alert.html("");

    if (!name) {
      e.preventDefault();
      return alert.append(
        `<div class='bg-red-300 text-red-500 px-4 py-2 rounded-md border-red-500' >Nama tidak boleh kosong</div>`
      );
    }

    const regexName = new RegExp(/^[a-zA-Z ]*$/);
    if (!regexName.test(name)) {
      e.preventDefault();
      return alert.append(
        `<div class='bg-red-300 text-red-500 px-4 py-2 rounded-md border-red-500' >Nama tidak boleh mengandung angka dan spesial karakter</div>`
      );
    }
    formData.append("name", name);

    if (!email) {
      e.preventDefault();
      return alert.append(
        `<div class='bg-red-300 text-red-500 px-4 py-2 rounded-md border-red-500' >Email tidak boleh kosong</div>`
      );
    }

    const regexEmail = new RegExp(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/);
    if (!regexEmail.test(email)) {
      e.preventDefault();
      return alert.append(
        `<div class='bg-red-300 text-red-500 px-4 py-2 rounded-md border-red-500' >Format email belum valid</div>`
      );
    }
    formData.append("email", email);

    if (files.length < 1) {
      e.preventDefault();
      return alert.append(
        `<div class='bg-red-300 text-red-500 px-4 py-2 rounded-md border-red-500' >Foto tidak boleh kosong</div>`
      );
    }
    formData.append("file", files[0]);

    $.ajax({
      url: "/post.php",
      data: formData,
      processData: false,
      contentType: false,
      type: "POST",
      success: function (response) {
        if (!response.success) {
          return response.errors.forEach((item) => {
            alert.append(
              `<div class='bg-red-300 text-red-500 px-4 py-2 rounded-md border-red-500' >${item}</div>`
            );
          });
        }
        $("#name").val('');
        $("#email").val('');
        $('#file').val('');
        $("#preview").attr("src", '');

        confirm("Berhasil menyimpan data");
        return window.location.reload();
      },
    });
  });
});
