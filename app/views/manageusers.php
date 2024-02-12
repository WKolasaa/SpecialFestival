<?php
    include __DIR__ . '/header.php'; 
    ?>

       
    <title>User Management</title>
   
    <div class="sidebar">
        <a href="#" onclick="filterUsers('all')">All Users</a>
        <a href="#" onclick="filterUsers('admin')">Admin Users</a>
        <a href="#" onclick="filterUsers('customer')">Customer Users</a>
        <a href="#" onclick="filterUsers('visitor')">Visitor Users</a>
        <a href="#" onclick="sortUsers()">Sort Users</a>
    </div>
    <div class="content">
        <h2>User Management</h2>
        <input type="text" id="searchInput" placeholder="Search by username"></input>

        <!-- TODO: Add the search button or check if it search automatically-->
        <!-- <button onclick="searchUsers()">Search</button> -->
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userList">
        </table>
    </div> 

    <script>src="js/manageUser.js"</script>

    <?php
    include __DIR__ . '/footer.php'; 
    ?>
    