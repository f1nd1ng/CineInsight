<div class="col">
  <div class="card h-100 shadow-sm border-0 rounded-4 movie-card" id="card<?php echo $id ?>">
    <img src="<?php echo $poster ?: 'default-image.jpg'; ?>" class="card-img-top rounded-top" alt="Movie Poster">
    <div class="card-body d-flex flex-column justify-content-between">
      <div>
        <h5 class="card-title fw-bold text-truncate" style="height: 3rem;"><?php echo htmlspecialchars($name) ?></h5>
        <p class="card-text text-muted" style="font-size: 0.9rem; height: 4.5rem; overflow: hidden;"><?php echo htmlspecialchars($summary) ?></p>
        <div class="mb-2 small">
          <span class="badge bg-warning text-dark me-2">IMDb: <?php echo htmlspecialchars($rating) ?></span>
          <span class="badge bg-secondary">⏱ <?php echo htmlspecialchars($duration) ?></span>
        </div>
      </div>
      <div class="mt-2 d-flex justify-content-between align-items-center">
        <a href="./movie_page.php?id=<?php echo $id ?>" class="btn btn-outline-success btn-sm">Details</a>
        <button type="button" id="butt<?php echo $id ?>" class="btn btn-sm btn-outline-warning fav-btn">★ Fav</button>
      </div>
    </div>
  </div>
</div>

<style>
  .movie-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  .movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }
  .fav {
    background-color: #ffe066 !important;
    color: black !important;
  }
</style>

<script>
  document.getElementById("butt<?php echo $id ?>").onclick = function () {
    const element = document.getElementById("butt<?php echo $id ?>");
    if (element.classList.contains("fav")) {
      element.classList.remove("fav");
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          console.log("Removed from fav");
        }
      };
      xhttp.open("GET", "fav.php?movie=<?php echo $id ?>&fav=0", true);
      xhttp.send();
    } else {
      element.classList.add("fav");
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          console.log("Added to fav");
        }
      };
      xhttp.open("GET", "fav.php?movie=<?php echo $id ?>&fav=1", true);
      xhttp.send();
    }
  };
</script>
