window.onload = function() {
    const contactForm = document.getElementById('contactForm');
    const searchInput = document.getElementById('searchInput');
    const contactList = document.getElementById('contactList');
  
    // Event listener for form submission
    contactForm.addEventListener('submit', function(event) {
      event.preventDefault();
      saveContact();
    });
  
    // Event listener for search input
    searchInput.addEventListener('input', function() {
      searchContacts();
    });
  
    // Fetch existing contacts on page load
    fetchContacts();
  
    // Function to save a contact
function saveContact() {
    const contactId = document.getElementById('contactId').value;
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const middleName = document.getElementById('middleName').value;
    const address = document.getElementById('address').value;
    const phoneNumber = document.getElementById('phoneNumber').value;
    const email = document.getElementById('email').value;
    const notes = document.getElementById('notes').value;
  
    // Validate required fields
    if (firstName.trim() === '' || phoneNumber.trim() === '') {
      alert('First name and phone number are required!');
      return;
    }
  
    // Phone number validation
    const phoneNumberRegex = /^(\+?\d{1,3})?[-\s]?\d{3}[-\s]?\d{3,4}[-\s]?\d{3,4}$/;
    if (!phoneNumberRegex.test(phoneNumber)) {
      alert('Invalid phone number format!');
      return;
    }
  
    // Create a new contact object
    const contact = {
      id: contactId,
      firstName: firstName,
      lastName: lastName,
      middleName: middleName,
      address: address,
      phoneNumber: phoneNumber,
      email: email,
      notes: notes
    };
  
    // Send the contact data to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_contact.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Contact saved successfully, fetch the updated contact list
        fetchContacts();
        resetForm();
      }
    };
    xhr.send(JSON.stringify(contact));
  }
  
  
    // Function to fetch contacts
    function fetchContacts() {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'get_contacts.php', true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          const contacts = JSON.parse(xhr.responseText);
          displayContacts(contacts);
        }
      };
      xhr.send();
    }
  
    // Function to display contacts
    function displayContacts(contacts) {
      // Sort contacts by last name and first name
      contacts.sort(function(a, b) {
        const nameA = a.last_name + a.first_name;
        const nameB = b.last_name + b.first_name;
        return nameA.localeCompare(nameB);
      });
  
      contactList.innerHTML = '';
  
      // Create table structure
      const table = document.createElement('table');
      table.classList.add('contact-table');
  
      // Create table header
      const tableHeader = document.createElement('thead');
      const headerRow = document.createElement('tr');
      headerRow.innerHTML = `
        <th>Last Name</th>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Notes</th>
        <th></th>
        <th></th>
      `;
      tableHeader.appendChild(headerRow);
      table.appendChild(tableHeader);
  
      // Create table body
      const tableBody = document.createElement('tbody');
      for (let i = 0; i < contacts.length; i++) {
        const contact = contacts[i];
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${contact.last_name}</td>
          <td>${contact.first_name}</td>
          <td>${contact.middle_name}</td>
          <td>${contact.address}</td>
          <td>${contact.phone_number}</td>
          <td>${contact.email}</td>
          <td>${contact.notes}</td>
          <td><button onclick="editContact(${contact.id})">Edit</button></td>
          <td><button onclick="deleteContact(${contact.id})">Delete</button></td>
        `;
        tableBody.appendChild(row);
      }
      table.appendChild(tableBody);
  
      contactList.appendChild(table);
    }
  
    // Function to edit a contact
    window.editContact = function(contactId) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'get_contact.php?id=' + contactId, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          const contact = JSON.parse(xhr.responseText);
          populateForm(contact);
        }
      };
      xhr.send();
    }
  
    // Function to delete a contact
    window.deleteContact = function(contactId) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'delete_contact.php?id=' + contactId, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          // Contact deleted successfully, fetch the updated contact list
          fetchContacts();
          resetForm();
        }
      };
      xhr.send();
    }
  
    // Function to populate the form with contact data
    function populateForm(contact) {
      document.getElementById('contactId').value = contact.id;
      document.getElementById('firstName').value = contact.first_name;
      document.getElementById('lastName').value = contact.last_name;
      document.getElementById('middleName').value = contact.middle_name;
      document.getElementById('address').value = contact.address;
      document.getElementById('phoneNumber').value = contact.phone_number;
      document.getElementById('email').value = contact.email;
      document.getElementById('notes').value = contact.notes;
    }
  
    // Function to reset the form
    function resetForm() {
      document.getElementById('contactId').value = '';
      document.getElementById('firstName').value = '';
      document.getElementById('lastName').value = '';
      document.getElementById('middleName').value = '';
      document.getElementById('address').value = '';
      document.getElementById('phoneNumber').value = '';
      document.getElementById('email').value = '';
      document.getElementById('notes').value = '';
    }
  
    // Function to search contacts
    function searchContacts() {
      const searchTerm = searchInput.value.toLowerCase();
      const contactItems = contactList.getElementsByTagName('tr');
  
      for (let i = 0; i < contactItems.length; i++) {
        const contactItem = contactItems[i];
        const contactFields = contactItem.getElementsByTagName('td');
        let foundMatch = false;
  
        for (let j = 0; j < contactFields.length; j++) {
          const fieldValue = contactFields[j].innerText.toLowerCase();
          if (fieldValue.includes(searchTerm)) {
            foundMatch = true;
            break;
          }
        }
  
        if (foundMatch) {
          contactItem.style.display = 'table-row';
        } else {
          contactItem.style.display = 'none';
        }
      }
    }
  };
  