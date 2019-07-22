<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Plan lekcji</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item<?php echo ((isset($consts['currentPage']) && $consts['currentPage'] === 'landingPage') ? " active" : ""); ?>">
          <a class="nav-link" href="landingPage.php">Strona główna</a>
        </li>
        <li class="nav-item<?php echo ((isset($consts['currentPage']) && $consts['currentPage'] === 'classes') ? " active" : ""); ?>">
          <a class="nav-link" href="classes.php">Przedmioty</a>
        </li>
        <li class="nav-item<?php echo ((isset($consts['currentPage']) && $consts['currentPage'] === 'teachers') ? " active" : ""); ?>">
          <a class="nav-link" href="teachers.php">Nauczyciele</a>
        </li>
      </ul>
      <ul class="navbar-nav my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Wyloguj</a>
        </li>
      </ul>
    </div>
  </nav>
</header>