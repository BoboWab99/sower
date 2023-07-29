/**
 * @param {String} email 
 */
function isValidEmail(email) {
   // [a-zA-Z0-9._%+-]+ matches one or more occurrences of letters (both lowercase and uppercase), digits, dots, underscores, percent signs, plus signs, or hyphens, which are commonly allowed characters in the local part of an email address.
   // [a-zA-Z0-9.-]+ matches one or more occurrences of letters (both lowercase and uppercase), digits, dots, or hyphens, which are commonly allowed characters in the domain part of an email address.
   // [a-zA-Z]{2,} matches two or more occurrences of letters (both lowercase and uppercase) for the top-level domain (TLD) part of the email address. This ensures the TLD contains at least two characters (e.g., ".com", ".org").
   const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
   return emailRegex.test(email);
}

/**
 * @param {String} password 
 */
function isValidPassword(password) {
   // (?=.*[a-z]) is a positive lookahead assertion that checks for at least one lowercase letter.
   // (?=.*[A-Z]) is a positive lookahead assertion that checks for at least one uppercase letter.
   // (?=.*\d) is a positive lookahead assertion that checks for at least one digit.
   // .{8,} matches any character (except newline) at least 8 times, ensuring the minimum length of the password.
   const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
   return passwordRegex.test(password);
}

/**
 * @param {String} username 
 */
function isValidUsername(username) {
   // [a-zA-Z0-9_] matches any lowercase letter, uppercase letter, digit, or underscore.
   // {4,} matches the previous token (in this case, [a-zA-Z0-9_]) at least 4 times, ensuring the minimum length of 4 characters for the username.
   const usernameRegex = /^[a-zA-Z0-9_]{4,}$/;
   return usernameRegex.test(username);
}

/**
 * @param {String} name 
 */
function isValidName(name) {
   // [a-zA-Z\s'-] matches any lowercase or uppercase letter, whitespace (space), apostrophe ('), or hyphen (-).
   // {2,} matches the previous token (in this case, [a-zA-Z\s'-]) at least 2 times, ensuring a minimum length of 2 characters for the name.
   const nameRegex = /^[a-zA-Z\s'-]{2,}$/;
   return nameRegex.test(name);
}

// phone number validation
// https://github.com/catamphetamine/libphonenumber-js#parsephonenumberstring-options-or-defaultcountry-phonenumber
// https://github.com/google/libphonenumber
