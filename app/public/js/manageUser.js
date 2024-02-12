console.log("manageUser.js");
const users = [
  { id: 1, username: "user1", email: "user1@example.com", registrationDate: "2022-02-10", role: "admin" },
  { id: 2, username: "user2", email: "user2@example.com", registrationDate: "2022-02-11", role: "customer" },
  { id: 3, username: "user3", email: "user3@example.com", registrationDate: "2022-02-12", role: "visitor" }
  // Add more user data here
];

// Function to display users in the table
function displayUsers(users) {
  const userList = document.getElementById("userList");
  userList.innerHTML = "";
  users.forEach(user => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
          <td>${user.id}</td>
          <td>${user.username}</td>
          <td>${user.email}</td>
          <td>${user.registrationDate}</td>
          <td>
              <button onclick="editUser(${user.id})">Edit</button>
              <button onclick="deleteUser(${user.id})">Delete</button>
          </td>
      `;
      userList.appendChild(tr);
  });
}

// Function to filter users by role
function filterUsers(role) {
  let filteredUsers;
  if (role === 'all') {
      filteredUsers = users;
  } else {
      filteredUsers = users.filter(user => user.role === role);
  }
  displayUsers(filteredUsers);
}

// Function to sort users by registration date
function sortUsers() {
  const sortedUsers = users.slice().sort((a, b) => new Date(a.registrationDate) - new Date(b.registrationDate));
  displayUsers(sortedUsers);
}

// Initial display of all users
displayUsers(users);