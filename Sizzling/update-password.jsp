<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.sql.*" %>

<%
    String newPassword = request.getParameter("password");
    String confirmPassword = request.getParameter("confirmPassword");
    String token = request.getParameter("token");

    if (newPassword.equals(confirmPassword)) {
        // Update the password in the database (replace this with your database logic)
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");

            // Assuming you have a table named 'password_reset' with columns 'email' and 'token'
            PreparedStatement st1 = con.prepareStatement("SELECT email FROM password_reset WHERE token = ?");
            st1.setString(1, token);
            ResultSet rs = st1.executeQuery();

            if (rs.next()) {
                String email = rs.getString("email");

                // Assuming you have a table named 'registration' with columns 'Uemail' and 'Upassword'
                PreparedStatement st2 = con.prepareStatement("UPDATE registration SET Upassword = ? WHERE Uemail = ?");
                st2.setString(1, newPassword);
                st2.setString(2, email);
                st2.executeUpdate();

                // Delete the used token from the password_reset table
                PreparedStatement st3 = con.prepareStatement("DELETE FROM password_reset WHERE token = ?");
                st3.setString(1, token);
                st3.executeUpdate();

                con.close();
                response.sendRedirect("password-updated.html");
            } else {
                // Token not found, handle the error (redirect to an error page or show an error message)
                con.close();
                response.sendRedirect("token-not-found.html");
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    } else {
        // Passwords do not match, handle the error (redirect to an error page or show an error message)
        response.sendRedirect("password-mismatch.html");
    }
%>
