/** 
 * Check if the given IBAN is valid. It only supports support for German IBANs
 *
 * Calculation steps from https://www.hettwer-beratung.de/sepa-spezialwissen/sepa-kontoverbindungsdaten/iban-pr%C3%BCfziffer-berechnung/
 */
function validateIBAN(iban)
{
    // A = 10, B = 11, ...
    function charToNum(char)
    {
        return char - 64 + 9
    }

    // Enforce uppercase
    iban = iban.toUpperCase();

    // Remove leading and trailing spaces as well as all spaces inside
    iban = iban.trim().replaceAll(' ', '');

    // Check length
    if (iban.length !== 22) {
        return false;
    }

    // BBAN = "Bank code" + "Account number"
    let bban = iban.slice(4, 22);
    // e.g. DE = 131400
    let countryCode = charToNum(iban.charCodeAt(0)).toString() + charToNum(iban.charCodeAt(1)) + "00";
    let checkNumber = bban.toString() + countryCode.toString();
    let checkSum = Number(BigInt(checkNumber) % BigInt(97));
    console.log("checkSum", checkSum);
    let ibanCheckSum = (98 - checkSum).toString().padStart(2, '0');

    return iban.slice(2, 4) === ibanCheckSum;
}
