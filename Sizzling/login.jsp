<%@ page language="java" contentType="text/html; charset=ISO-8859-1" pageEncoding="ISO-8859-1" import="java.sql.*"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <title>Welcome</title>
</head>
<body>

<%
    String email = request.getParameter("email");
    String password = request.getParameter("password");

    Class.forName("com.mysql.cj.jdbc.Driver");
    Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");

    PreparedStatement st = con.prepareStatement("Select Uemail, Upassword from registration where Uemail=? and Upassword=?");
    st.setString(1, email);
    st.setString(2, password);

    ResultSet rs = st.executeQuery();

    if (rs.next()) {
        // Set session on successful login
        session.setAttribute("user", email);
        response.sendRedirect("booking.html");
    } else {
        response.sendRedirect("login-failed.html");
    }
%>

</body>
</html>
