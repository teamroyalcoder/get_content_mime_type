<pre>
Using this simple [ you can say bigger one 🤪 ] function, you can extract or get the mime type of 
a file or you can say content. But before for using this function you might have need done some 
pre-configuration, like you have to sure that you turned or configured 
curl extension, filesystem releted extension and finfo extension in php.ini file.

Here, I am describing the whole process of this function in a short.

1. First, we are storing all the updated mime type as an array from official  apache mime type url. 
You can also get this mime type file in your apache conf directory insted of using url. In this function 
we are using live url to get all the mime type.
2. But the zeroth process for this function is to validate that apache url is live or not.
3. After validating the url, if the url validate, we store all mimes from that url as an array called $mimes 
if the url isn't live or exist we are manually making an array with some common extension available.
4. Then we validate the content as file.
5. Then we check the PHP pathinfo function to insure that there is a file extension. and store it.
6. After that we finally checking the $mimes array with our content extension as $mimes array index.
7. Finally we are returning the index value of $mimes array as content mime type through $content_mime variable.
8. That's it.


Thanks for reading the explanation of this function or using my function.
Have a good day.
Md. Asaduzzaman Atik,
On behalf of Team RoyalCoder
visit www.teamroyalcoder.com for some real magic of tech.
</pre>
