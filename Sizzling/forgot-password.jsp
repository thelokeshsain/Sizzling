<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.sql.*, java.util.UUID" %>

<%
    String email = request.getParameter("email");

    // Generate a unique token
    String token = UUID.randomUUID().toString();

    // Embed the token in the URL
    String resetURL = "reset-password.jsp?token=" + token;

    // Store the token in the database (replace this with your database logic)
    try {
        Class.forName("com.mysql.cj.jdbc.Driver");
        Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");

        // Assuming you have a table named 'registration' with columns 'Uemail' and 'ResetToken'
        PreparedStatement st = con.prepareStatement("UPDATE registration SET ResetToken = ? WHERE Uemail = ?");
        st.setString(1, token);
        st.setString(2, email);
        st.executeUpdate();

        con.close();
    } catch (Exception e) {
        e.printStackTrace();
    }

    // Send an email to the user with the reset URL (implement this separately)

    // Redirect to a page where users can see a message about the password reset
    response.sendRedirect("password-reset-instructions.html");
%>
