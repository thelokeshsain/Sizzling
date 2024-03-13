<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1" import = "java.sql.*"%>
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
Connection con=DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling","root","admin");

PreparedStatement st = (PreparedStatement) con.prepareStatement("Select aemail, apass from admin"+ " where aemail=? and apass=?");
st.setString(1, email);
st.setString(2, password);

ResultSet rs = st.executeQuery();

if(rs.next()) //true if uname and pass match with database values
response.sendRedirect("successadminlogin.html");
else
response.sendRedirect("wrongadminpass.html");


%>

</body>
</html>