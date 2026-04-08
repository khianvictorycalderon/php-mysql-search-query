<?php

  // For database credentials and useful functions
  require_once("api/db.php");

  if (isset($_GET["search"])) {
    $search = "%" . $_GET["search"] . "%";

    // Tries to search the database
    $users = transactionalMySQLQuery("
      SELECT
        name,
        email,
        address
      FROM sample_users
      WHERE
        name LIKE ?
        OR email LIKE ?
        OR address LIKE ?
    ", [$search, $search, $search]);

  } else {
    // Fetch all normally in the database
    $users = transactionalMySQLQuery("
      SELECT
        name,
        email,
        address
      FROM sample_users
    ");
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    
    <!-- Forces the browser to load the latest version of this website -->
  	<meta http-equiv='cache-control' content='no-cache'> 
    <meta http-equiv='expires' content='0'> 
    <meta http-equiv='pragma' content='no-cache'>

    <!-- Misc -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png+jpg" href="icon-path">
    <script src="assets/tailwind-3.4.17.js"></script>
    
    <title>PHP + MySQL Search Query</title>

  </head>
  <body>

    <div class="min-h-screen w-full 
        bg-neutral-50 text-neutral-900
        flex items-center justify-center
        ">
        
        <div class="flex flex-col gap-2 text-center">
            <h2 class="text-4xl font-bold text-center">PHP + MySQL Search Query</h2>

            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Address</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user) { ?>
                  <tr>
                    <td><?= $user["name"]; ?></td>
                    <td><?= $user["email"]; ?></td>
                    <td><?= $user["address"] ?? "-----"; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
              <input
                name="search"
                class="bg-neutral-200 p-2 rounded-md mt-4"
                type="text"
                placeholder="Search name, email, or address..."
                value="<?= htmlspecialchars($_GET["search"] ?? "") ?>"
              >
              <input
                class="px-4 py-2 rounded-md bg-blue-500 text-white"
                type="submit" 
                value="Search"
              >
            </form>

        </div>
        
    </div>

  </body>
</html>