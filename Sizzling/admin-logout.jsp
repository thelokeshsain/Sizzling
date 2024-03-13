<%@ page language="java" contentType="text/html; charset=ISO-8859-1" pageEncoding="ISO-8859-1" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <title>Admin Logout</title>
</head>
<body>
    <%
        // Invalidate the session to log out the admin
        session.invalidate();
        response.sendRedirect("index.html"); // Redirect to the home page or another appropriate page
    %>
</body>
</html>
