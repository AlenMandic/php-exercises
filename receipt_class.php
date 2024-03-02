<?php
/** Napravio novu klasu Recept koja drži privatne podatke računa po modelu vaše slike. Ovi privatni podaci u stvarnosti
   * naprimjer mogu doći iz forme sa front-end dijela stranice ovisno o korisničkoj akciji, te prema njima mijenjamo i izbacujemo HTML
   *  podatke  po potrebi. Ovu klasu ćemo podijelit sa našim 'index.php' file-om pomoću 'include_once' ključne riječi. Na taj način će statični HTML iz 'index.php' imat pristup metodama naše klase, te sa logičkim dijelom/podacima naše aplikacije koji se nalazi ovdje.
   * Također sam se pobrinuo da je dokument responzivan na svakom ekranu.
   * Provjeru koda i testiranje sam radio pomoću built-in PHP servera: php -S localhost:3000
*/

class Receipt {

    // Table 1 data
    private $tipUsluge = "AS-16950-a";
    private $rasponDatuma = "08.08.2022 - 15.08.2022";
    private $brojLjudi = 2;
    private $brojNoćenja = 7;
    private $cijena = 104;

    // Table 2 data
    private $metodaPlaćanja = "Kreditnom karticom(Visa, EC/MC, Maestro)";
    private $prviRokIsplate = "Najkasnije 08.08.2022 do 11:00";
    private $drugiRokIsplate = "Najkasnije 08.08.2022 do 15:00";
    private $iznosIsplate = 364;

    public function izračunajUkupno() {
        return $this->cijena * $this->brojNoćenja;
    }

    // dio HTML-a koji treba koristiti logiku klase
    public function generateTable1HTML() {
        return '
            <tr>
                <td class="td-flex" id="big-container">
                    <p class="td-flex-item" id="service-type">' . $this->tipUsluge . '</p>
                    <p class="td-flex-item smaller-text" id="td-flex-shrink">' . $this->rasponDatuma . '</p>
                    <p class="td-flex-item smaller-text">' . $this->brojLjudi . ' (osobe)</p>
                </td>
                <td class="smaller-text">' . $this->cijena . ',00 €</td>
                <td class="smaller-text">' . $this->brojNoćenja . ' (noćenja)</td>
                <td class="smaller-text">' . $this->izračunajUkupno() . ',00 €</td>
            </tr>
            <tr>
                <td colspan="5" class="blank-row"></td>
            </tr>
            <tr>
                <td colspan="3">Ukupno</td>
                <td colspan="2">' . $this->izračunajUkupno() . ',00 €</td>
            </tr>
        ';
    }

    // dio HTML-a koji treba koristiti logiku klase
    public function generateTable2HTML() {
        return '
            <tr>
                <td>Akontacija</td>
                <td class="smaller-text">' . $this->metodaPlaćanja . '</td>
                <td class="smaller-text">' . $this->prviRokIsplate . '</td>
                <td>' . $this->iznosIsplate . ' €</td>
            </tr>
            <tr>
                <td>Ostatak iznosa</td>
                <td class="smaller-text">' . $this->metodaPlaćanja . '</td>
                <td class="smaller-text">' . $this->drugiRokIsplate . '</td>
                <td>' . $this->iznosIsplate . ' €</td>
            </tr>
        ';
    }
}
?>