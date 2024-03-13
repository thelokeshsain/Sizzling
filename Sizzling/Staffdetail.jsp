<%@page import="java.sql.*" %>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Staff</title>
    <link href="https://fonts.cdnfonts.com/css/algeria" rel="stylesheet">
    

</head>
<body>
    <h1 style="margin-top:20px; color:seagreen; font-family:algerian;font-size: 90px;text-align: center;">Our Managing Staff</h1>
    <table table style="width: 100%"; border="2">
        <tr style="background-color: gray; color: antiquewhite; font-weight: bold; height: 150px; font-size: 50px;text-align: center; ">
            <!-- <td>Staff ID</td> -->
            <td>Name</td>
            <td>Post</td>
            <td>About</td>
            <td>Contact</td>
        </tr>
    <%
    Connection con = null;
    Statement st = null;
    ResultSet rs = null;

    try{
        Class.forName("com.mysql.jdbc.Driver");
        con=(Connection)DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling","root","admin");
        st=con.createStatement();

        String querry="select * from staff";
        rs=st.executeQuery(querry);
        while(rs.next())
        {
        %>
        <tr style="height: 100px;">
            <!-- <td style="background-color:seagreen;font-weight: bold; text-align: center; font-size: 30px;color: antiquewhite;"><%= rs.getString(1) %></td> -->
            <td style="background-color:seagreen;font-weight: bold; text-align: center; font-size: 30px;color: antiquewhite;"><%= rs.getString(1) %></td>
            <td style="background-color:seagreen;font-weight: bold; text-align: center; font-size: 30px"><%= rs.getString(2) %></td>
            <td style="background-color:seagreen;font-weight: bold; text-align: center; font-size: 15px"><%= rs.getString(3) %></td>
            <td style="background-color:seagreen;font-weight: bold; text-align: center; font-size: 20px"><%= rs.getString(4) %></td>
        </tr>
        <%
    }
    } catch(Exception e){
        
    }

    %>
    </table>
    
</body>
</html>