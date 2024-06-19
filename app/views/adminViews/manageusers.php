<?php
include __DIR__ . '/../header.php';
?>


<title>User Management</title>

<div class="sidebar">
    <a href="#" onclick="filterUsers('all')">All Users</a>
    <a href="#" onclick="filterUsers('administrator')">Admin Users</a>
    <a href="#" onclick="filterUsers('customer')">Customer Users</a>
    <a href="#" onclick="filterUsers('Employee')">Employee Users</a>
    <button type="button" onclick="AddUser()" class="btn btn-dark" style="width: 150px;">Add User</button>
    <!-- <button onclick="AddUser()">Add User</button> -->

</div>
<div class="content">
    <h2>User Management</h2>
    <div class="searchUser">
        <div class="sortBy">
            <label class="sort-label" for="sortSelect">Sort By</label>
            <select class="form-select combo-box" id="sortSelect" aria-label="Floating label select example">
                <option value="id">ID</option>
                <option value="username">Username</option>
                <option value="userRole">Role</option>
                <option value="registrationDate">Registration Date</option>
            </select>
        </div>
        <div class="input-group">
            <input type="text" id="searchInput" placeholder="Search by username">
            <button type="button" class="btn btn-success" onclick="searchUsers()">Success</button>
        </div>
    </div>


    <table id="userTable">
        <thead id="tableHead">
        <tr>
            <th class="id-column">ID</th>
            <th class="userName-column">Username</th>
            <th>Role</th>
            <th class="registrationDate-column">Registration Date</th>
        </tr>
        </thead>
        <tbody id="userList">

    </table>
</div>

<script src="/js/adminViews/manageUser.js"></script>
<?php
include __DIR__ . '/../footer.php';
?>
    