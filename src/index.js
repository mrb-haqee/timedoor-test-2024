$(document).ready(function () {
  // Toggle Button
  $("nav div button").click(function () {
    $("nav div button").removeClass("active");
    $(this).addClass("active");

    var targetId = $(this).data("target");
    $("section").removeClass("active");
    $("#" + targetId).addClass("active");
  });

  // OnChange Booklist by Author Name
  $("#author-name").on("change", function () {
    var authorId = $(this).val();
    $.ajax({
      type: "GET",
      url: "index.php",
      data: {
        author_id: authorId,
      },
      success: function (resp) {
        $("#book-name").html(resp);
      },
      error: function (xhr, status, error) {
        console.error("Terjadi kesalahan: " + error);
      },
    });
  });

  // Handle Request input Rating
  $("#rating-form").submit(function (e) {
    e.preventDefault();

    var authorId = $("#author-name").val();
    var bookId = $("#book-name").val();
    var rating = $("#rating").val();

    if (!authorId || !bookId || !rating) {
      alert("Pilih Author terlebih dahulu!");
      return;
    }

    $.ajax({
      type: "POST",
      url: "index.php",
      data: {
        author_id: authorId,
        book_id: bookId,
        rat: rating,
      },
      success: function (resp) {
        console.log(resp);
        setTimeout(function () {
          // alert(resp);
          location.reload(true);
        }, 1000);
      },

      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  });
});
