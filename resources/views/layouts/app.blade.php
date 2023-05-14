<!-- app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>EDM Laravel Loan Calculator App  - Hsn Rashid</title>
    <!-- Include your CSS and JavaScript files -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Include your navigation bar or header section here -->
    <header class="sticky-header">
    <nav>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="https://github.com/human06/EDMLoanCalculator" target="blank">GitHub</a></li>
      </ul>
    </nav>
  </header>
    <!-- Content section -->
    <div class="container">
    @yield('content')

    </div>
    
</body>
</html>
