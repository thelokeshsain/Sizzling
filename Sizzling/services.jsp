<%@ page language="java" contentType="text/html; charset=ISO-8859-1" pageEncoding="ISO-8859-1" import="java.sql.*" %>
<%@ page import="java.io.*,java.util.*" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <title>Services</title>
</head>
<body>
<%
    Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");
    Statement stmt = con.createStatement();
    ResultSet rs = stmt.executeQuery("SELECT * FROM services");

    while (rs.next()) {
        String serviceName = rs.getString("service_name");
        String serviceImage = rs.getString("service_image");
        int servicePrice = rs.getInt("service_price");

        out.println("<div class='service-item'>");
        out.println("<img src='" + serviceImage + "' alt='" + serviceName + "'>");
        out.println("<h2>" + serviceName + "</h2>");
        out.println("<p>Description of the service goes here.<br> ₹ " + servicePrice + "</p>");
        out.println("<a href='login.html' class='cta-button'>Choose Services</a>");
        out.println("</div>");
    }

    con.close();
%>
</body>
</html>
