let allUsers = [];
function loadData() {
  fetch("/api/ManageUser")
    .then((response) => response.json())
    .then((data) => {
      allUsers = data; // Store all users in the array
      displayUsers(allUsers); // Display all users by default
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
}

// Function to display users based on the provided list
function displayUsers(users) {
  const userList = document.getElementById("userList");
  userList.innerHTML = ""; // Clear existing table rows

  users.forEach((user) => {
    const row = document.createElement("tr");

    // Add data to the row
    row.innerHTML = `
            <td class="id-column">${user.id}</td>
            <td class="username-column">${user.username}</td>
            <td class="role-column">${user.userRole}</td>
            <td class="registrationDate-column">${user.registeredDate}</td>
            <td class="button-column">
            <button type="button" class="btn btn-secondary edit-button" style="--bs-btn-padding-y: .75rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: 1rem; margin-right: 5px; border-radius: 10px;">
            <i class="fas fa-edit"></i> 
        </button>
            <button type="button" class="btn btn-danger delete-button" style="--bs-btn-padding-y: .75rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: 1rem; border-radius: 10px;">
            <i class="fas fa-trash"></i> 
        </button>

                                    
            </td>
        `;

    // Append row to the table body
    userList.appendChild(row);
  });

  // Add event listeners to edit buttons
  const editButtons = document.querySelectorAll(".edit-button");
  editButtons.forEach((button) => {
    button.addEventListener("click", handleEditUser);
  });
}

// Function to filter users based on their roles
function filterUsers(role) {
  if (role === "all") {
    displayUsers(allUsers); // Display all users
    restoreHeaders();
  } else {
    const filteredUsers = allUsers.filter(
      (user) => user.userRole.toLowerCase() === role.toLowerCase()
    );
    displayUsers(filteredUsers); // Display users with the specified role
    restoreHeaders();
  }
}

function searchUsers() {
  const searchTerm = document.getElementById("searchInput").value.toLowerCase();
  const filteredUsers = allUsers.filter((user) =>
    user.username.toLowerCase().includes(searchTerm)
  );
  displayUsers(filteredUsers);
}

// Function to initialize sorting functionality
function initSorting() {
  const sortSelect = document.getElementById("sortSelect");

  sortSelect.addEventListener("change", () => {
    const sortCriteria = sortSelect.value;
    sortUsers(sortCriteria, false);
  });
}

// Function to sort users based on the specified criteria
function sortUsers(criteria, reverse) {
  const sortedUsers = [...allUsers];

  sortedUsers.sort((a, b) => {
    let comparison = 0;
    if (a[criteria] > b[criteria]) {
      comparison = 1;
    } else if (a[criteria] < b[criteria]) {
      comparison = -1;
    }
    return reverse ? comparison * -1 : comparison;
  });

  displayUsers(sortedUsers);
}

// Function to handle edit button clicks
function handleEditUser(event) {
  const row = event.target.closest("tr");
  const cells = row.querySelectorAll("td:not(.button-column)");

  cells.forEach((cell, index) => {
    if (index === 2) {
      // Check if it's the userRole column so we can replace the text with a select element
      const currentValue = cell.textContent.trim();
      // Create a select element with options for user roles
      const selectElement = document.createElement("select");
      selectElement.classList.add("form-select", "rounded");

      selectElement.innerHTML = `
                <option value="CUSTOMER">Customer</option>
                <option value="EMPLOYEE">Employee</option>
                <option value="ADMINISTRATOR">Administrator</option>
            `;
      // Set the current value as selected
      selectElement.value = currentValue;
      // Replace the cell content with the select element
      cell.innerHTML = "";
      cell.appendChild(selectElement);
    } else if (index !== 0 && index !== 3) {
      // Skip the ID and registration date columns from editing
      const currentValue = cell.textContent.trim();
      cell.innerHTML = `<div class="input-group input-group-sm mb-2">
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="${currentValue}" style="height:30px; ">
            </div>`;
    }
  });

  // Replace edit button with save button
  const buttonColumn = row.querySelector(".button-column");
  buttonColumn.innerHTML = `
        <button type="button" class="btn btn-success save-button" onclick="saveChanges(event)">
            <i class="fas fa-check"></i>
        </button>
    `;
}

loadData();
initSorting();

function constructUserObject(id, username, userRole) {
  return {
    id: id,
    username: username,
    userRole: userRole,
  };
}
// Function to handle saving changes
function saveChanges(event) {
  const row = event.target.closest("tr");
  const id = row.querySelector(".id-column").textContent;
  const cells = row.querySelectorAll("td:not(.button-column)");

  // Initialize variables to hold the input values
  let username = "";
  let userRole = "";

  // Check if input elements exist in the cells
  if (cells.length > 1) {
    const usernameInput = cells[1].querySelector("input");
    username = usernameInput ? usernameInput.value : "";
  }
  if (cells.length > 2) {
    const userRoleSelect = cells[2].querySelector("select");
    userRole = userRoleSelect ? userRoleSelect.value : "";
  }
  if (!username || !userRole) {
    alert("Please provide both username and user role.");
    return;
  }

  // Construct the updated user object
  const updatedUser = constructUserObject(id, username, userRole);

  /////////////////////////update user info//////////////////////////////
  // Send the updated data to the server using a POST request
  fetch("/api/ManageUser/updateUser", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(updatedUser),
  })
    .then((response) => {
      if (response.ok) {
        showToast("User information updated successfully!", "#008000");
        loadData();
        // Reset the table to its original state
        resetTable();
      } else {
        // Handle error response
        alert("Failed to update user information. Please try again.");
      }
    })
    .catch((error) => {
      // Handle network errors
      console.error("Error updating user information:", error);
      alert("An error occurred while updating user information.");
    });
}

// Function to reset the table to its original state
function resetTable() {
  // Deselect any selected rows
  const selectedRow = document.querySelector("tr.selected");
  if (selectedRow) {
    selectedRow.classList.remove("selected");
  }

  // Restore edit buttons
  const editButtons = document.querySelectorAll(".save-button");
  editButtons.forEach((button) => {
    const parentCell = button.parentElement;
    const editButton = document.createElement("button");
    editButton.setAttribute("type", "button");
    editButton.classList.add("btn", "btn-secondary", "edit-button");
    editButton.style.cssText =
      "--bs-btn-padding-y: .75rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: 1rem; margin-right: 5px; border-radius: 10px;";
    editButton.innerHTML = '<i class="fas fa-edit"></i>';

    const deleteButton = document.createElement("button");
    deleteButton.setAttribute("type", "button");
    deleteButton.classList.add("btn", "btn-danger", "delete-button");
    deleteButton.style.cssText =
      "--bs-btn-padding-y: .75rem; --bs-btn-padding-x: .75rem; --bs-btn-font-size: 1rem; border-radius: 10px;";
    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';

    parentCell.innerHTML = "";
    parentCell.appendChild(editButton);
    parentCell.appendChild(deleteButton);
  });

  // Remove input elements from table cells
  const inputCells = document.querySelectorAll("td:not(.button-column) input");
  inputCells.forEach((inputCell) => {
    const cellValue = inputCell.value;
    inputCell.parentElement.textContent = cellValue;
  });

  // Remove select elements from table cells
  const selectCells = document.querySelectorAll(
    "td:not(.button-column) select"
  );
  selectCells.forEach((selectCell) => {
    const selectedValue = selectCell.value;
    selectCell.parentElement.textContent = selectedValue;
  });
}

/////////////////////////Delete user /////////////////////////////
// Function to handle delete button click
document.addEventListener("DOMContentLoaded", () => {
  // Step 1: Select all delete buttons
  const deleteButtons = document.querySelectorAll(".delete-button");

  // Step 2: Add event listeners to delete buttons
  deleteButtons.forEach((button) => {
    button.addEventListener("click", handleDeleteButtonClick);
  });

  document.addEventListener("click", function (event) {
    const deleteButton = event.target.closest(".delete-button");

    if (deleteButton) {
      handleDeleteButtonClick(event);
    }
  });
});

// Step 3: Define the event handler for delete button click
function handleDeleteButtonClick(event) {
  // Step 4: Extract user ID from the clicked row
  const row = event.target.closest("tr"); // Find the closest row element
  const idCell = row.querySelector(".id-column");
  const id = idCell.textContent; // Get the user ID from the cell content

  // Extract username and userRole
  const usernameCell = row.querySelector(".username-column");
  const username = usernameCell.textContent;
  const roleCell = row.querySelector(".role-column");
  const userRole = roleCell.textContent;

  // Step 5: Confirm deletion with the user
  const confirmDelete = confirm("Are you sure you want to delete this user?");
  if (!confirmDelete) return;

  const deletedUser = constructUserObject(id, username, userRole);

  // Step 6: Send DELETE request to server
  fetch(`/api/ManageUser/deleteUserByAdmin`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(deletedUser),
  })
    .then((response) => {
      //console.log(updatedUser);
      if (response.ok) {
        // console.log("User ID:", id)
        showToast("User deleted successfully!", "#008000");
        loadData();
      } else {
        alert("Failed to delete user. Please try again.");
      }
    })
    .catch((error) => {
      console.error("Error deleting user:", error);
      alert("An error occurred while deleting user.");
    });
}

/////////////////////////Create user /////////////////////////////

function AddUser() {
  const userList = document.getElementById("userList");
  const idHeader = document.querySelector(".id-column");
  const usernameHeader = document.querySelector(".userName-column");
  idHeader.innerHTML = "Username";
  usernameHeader.innerHTML = "Password";
  userList.innerHTML = "";

  // Display form fields for adding a new user
  const addUserForm = `
        
        <tr id="addUserRow">
        <td><input type="text" class="form-control" id="newUsername" placeholder="Enter username" style="width: 100%;"></td>
            <td><input type="password" class="form-control" id="newPassword" placeholder="Enter password" ></td>
            <td>
                <select class="form-select" id="newUserRole">
                    <option value="CUSTOMER">Customer</option>
                    <option value="EMPLOYEE">Employee</option>
                    <option value="ADMINISTRATOR">Administrator</option>
                </select>
            </td>
            <td>
            <button type="button" class="btn btn-success save-button" onclick="saveNewUser()" style="border: none;">
            <i class="fas fa-check"></i> 
        </button>
            </td>
        </tr>
    `;
  userList.innerHTML = addUserForm;

  const registrationDateHeader = document.querySelector(
    ".registrationDate-column"
  );
  if (registrationDateHeader) {
    registrationDateHeader.textContent = "Action";
  }
}
function saveNewUser() {
  // Get the input values
  const newUsername = document.getElementById("newUsername").value;
  const newPassword = document.getElementById("newPassword").value;
  const newUserRole = document.getElementById("newUserRole").value;

  // Validate input fields
  if (!newUsername || !newPassword || !newUserRole) {
    alert("Please provide username, password, and role.");
    return;
  }

  // Construct the new user object
  const newUser = {
    username: newUsername,
    password: newPassword,
    userRole: newUserRole,
  };

  // Send the new user data to the server using a POST request
  fetch("/api/ManageUser/createUserByAdmin", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(newUser),
  })
    .then((response) => {
      if (response.ok) {
        showToast("User created successfully!", "#008000");
        loadData(); // Reload the user data
        restoreHeaders();
      } else {
        alert("Failed to create user. Please try again.");
      }
    })
    .catch((error) => {
      console.error("Error creating user:", error);
      alert("An error occurred while creating user.");
    });
}

// event listener to the "Save" button for adding a new user
document.addEventListener("DOMContentLoaded", () => {
  const saveButton = document.querySelector(".save-button");
  if (saveButton) {
    saveButton.addEventListener("click", saveNewUser);
  }
});

function restoreHeaders() {
  const idHeader = document.querySelector(".id-column");
  const usernameHeader = document.querySelector(".userName-column");
  const registrationDateHeader = document.querySelector(
    ".registrationDate-column"
  );

  if (idHeader) {
    idHeader.textContent = "ID";
  }

  if (usernameHeader) {
    usernameHeader.textContent = "Username";
  }

  if (registrationDateHeader) {
    registrationDateHeader.textContent = "Registration Date";
  }
}
