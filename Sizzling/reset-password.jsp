<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page isErrorPage="true" %>
<%@ page errorPage="error.jsp" %>
<%@ page import="java.sql.Connection, java.sql.DriverManager, java.sql.PreparedStatement, java.sql.ResultSet, java.sql.SQLException"%>

<%
    System.out.println("Inside reset-password.jsp");

    String token = request.getParameter("token");
    System.out.println("Token from URL: " + token);

    try {
        Class.forName("com.mysql.cj.jdbc.Driver");
        Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");

        PreparedStatement st = con.prepareStatement("SELECT Uemail FROM registration WHERE ResetToken = ?");
        st.setString(1, token);
        ResultSet rs = st.executeQuery();

        if (rs.next()) {
            // Token is valid, allow the user to reset the password
%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sizzling Hair Salon</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Add your stylesheets and other necessary resources -->
</head>
<body>
    <main>
        <div class="reset-password-container">
            <h1>Reset Password</h1>
            <form action="update-password.jsp" method="post">
                <input type="hidden" name="token" value="<%= token %>">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>

                <button type="submit">Reset Password</button>
            </form>
        </div>
    </main>
</body>
</html>
<%
        } else {
            // Token is invalid, redirect to an error page or show an error message
            System.out.println("Invalid Token. Redirecting to invalid-token.html");
            response.sendRedirect("invalid-token.html");
        }

        con.close();
    } catch (SQLException | ClassNotFoundException e) {
        e.printStackTrace();
    }
%>
