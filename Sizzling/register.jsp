<%@ page import="java.sql.*" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Registration</title>
</head>
<body>

<%
    String uname = request.getParameter("uname");
    String upassword = request.getParameter("upassword");
    String uemail = request.getParameter("uemail");

    // Convert mobile number to int
    int umobile = 0;
    try {
        umobile = Integer.parseInt(request.getParameter("umobile"));
    } catch (NumberFormatException e) {
        out.println("<p>Error: Invalid mobile number.</p>");
        return;
    }

    String uaddress = request.getParameter("uaddress");
    String ucity = request.getParameter("ucity");

    Connection conn = null;
    PreparedStatement pstmt = null;

    try {
        Class.forName("com.mysql.cj.jdbc.Driver");
        conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");

        String query = "INSERT INTO registration (Uname, Upassword, Uemail, Umobile, Uaddress, Ucity) VALUES (?, ?, ?, ?, ?, ?)";
        pstmt = conn.prepareStatement(query);
        pstmt.setString(1, Uname);
        pstmt.setString(2, Upassword);
        pstmt.setString(3, Uemail);
        pstmt.setInt(4, Umobile);
        pstmt.setString(5, Uaddress);
        pstmt.setString(6, Ucity);

        int rowsAffected = pstmt.executeUpdate();

        if (rowsAffected > 0) {
            out.println("<p>Registration successful!</p>");
        } else {
            out.println("<p>Registration failed. Please try again.</p>");
        }
    } catch (Exception e) {
        out.println("<p>Error: " + e.getMessage() + "</p>");
    } finally {
        if (pstmt != null) {
            try { pstmt.close(); } catch (SQLException e) { /* ignored */ }
        }
        if (conn != null) {
            try { conn.close(); } catch (SQLException e) { /* ignored */ }
        }
    }
%>

<form method="post" action="register.jsp">
    <label for="uname">Username:</label>
    <input type="text" id="uname" name="uname" required>

    <label for="upassword">Password:</label>
    <input type="password" id="upassword" name="upassword" required>

    <label for="uemail">Email:</label>
    <input type="email" id="uemail" name="uemail" required>

    <label for="umobile">Mobile:</label>
    <input type="text" id="umobile" name="umobile" required>

    <label for="uaddress">Address:</label>
    <input type="text" id="uaddress" name="uaddress" required>

    <label for="ucity">City:</label>
    <input type="text" id="ucity" name="ucity" required>

    <button type="submit">Register</button>
</form>

</body>
</html>
