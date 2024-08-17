# Zoho CRM Deal and Account Form

This project is a web application that allows users to create a Deal and an Account in Zoho CRM using a form built with Vue.js on the frontend and Laravel on the backend. The application integrates with the Zoho CRM API to facilitate these operations.

## Features

-   **Create Deal and Account**: Users can fill out a form to create a Deal and an Account in Zoho CRM.
-   **Field Mapping**: The form fields are mapped directly to Zoho CRM fields:
    -   Deal Name -> `Deal Name`
    -   Deal Stage -> `Stage`
    -   Account Name -> `Account Name`
    -   Account Website -> `Website`
    -   Account Phone -> `Phone`
-   **Linked Records**: The created Deal and Account records are automatically linked in Zoho CRM.
-   **Form Validation**: All fields are validated to ensure valid input. Error messages are displayed if the input is invalid.
-   **Success/Error Feedback**: Users receive feedback messages on successful creation or failure of the records.
-   **Automatic Token Refresh**: The application implements an automatic token refresh mechanism to ensure that records can be created at any time.
