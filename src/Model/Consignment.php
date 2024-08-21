<?php

namespace Webit\GlsAde\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Consignment
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/structures/s_consign.htm
 *
 * Tablica transportuje dane na temat przesyłki oraz paczek.
 *
 * Szczególną uwagę należy zwrócić na właściwe wykorzystanie tej struktury dla usług PR, PS, EXC i SRS,
 * ponieważ zasadniczej zmianie ulega wykorzystanie elementów związanych z adresami (doręczenia, odbioru).
 * Uwagi na ten temat są podane w opisie tablicy ServicePPE.
 *
 * Sekcja z prefiksem r (od rrname1 do rcontact) w przypadku usług PR, PS, EXC i SRS
 * nie musi być wypełniana (odpowiednie dane zostaną pobrane z tablicy ServicePPE).
 */
class Consignment
{

    /**
     * Identyfikator przesyłki
     *
     */
    private int $id;

    /**
     * Pierwsza część nazwy odbiorcy (tzw. Nazwa 1)
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rname1")
     * @JMS\Groups({"input"})
     *
     */
    private string $rname1;

    /**
     * Druga część nazwy odbiorcy (tzw. Nazwa 2)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rname2")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $rname2 = null;

    /**
     * Trzecia część nazwy odbiorcy (tzw. Nazwa 3)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rname3")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $rname3 = null;

    /**
     * Kod kraju odbiorcy (zgodny z ISO 3166-1 alfa-2)
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rcountry")
     * @JMS\Groups({"input"})
     *
     */
    private string $rcountry;

    /**
     * Kod pocztowy odbiorcy
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rzipcode")
     * @JMS\Groups({"input"})
     *
     */
    private string $rzipcode;

    /**
     * Nazwa miejscowości odbiorcy
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rcity")
     * @JMS\Groups({"input"})
     *
     */
    private string $rcity;

    /**
     * Ulica odbiorcy
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rstreet")
     * @JMS\Groups({"input"})
     *
     */
    private string $rstreet;

    /**
     * Telefony do odbiorcy
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rphone")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $rphone = null;

    /**
     * Email, osoba kontaktowa odbiorcy
     * (string)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rcontact")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $rcontact = null;

    /**
     * Referencje (pole to jest drukowane na etykietach, zazwyczaj podaje się
     * w tym polu skrócony opis zawartości paczki, nr zamównienia etc.)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("references")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $references = null;

    /**
     * Uwagi
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("notes")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $notes = null;

    /**
     * Ilość paczek w przesyłce, zawartość pola jest automatycznie korygowana
     * na podstawie zawartości elementów tablicy z paczkami.
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("quantity")
     * @JMS\Groups({"input"})
     *
     */
    private ?int $quantity = null;

    /**
     * Waga wszystkich paczek w przesyłce [kg], zawartość pola jest automatycznie korygowana
     * na podstawie zawartości elementów tablicy z paczkami.
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("weight")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $weight = null;

    /**
     * Data nadania, jeśli brak zostanie wstawiona aktualna data [YYYY-MM-DD]
     * (Opcja)
     *
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\SerializedName("date")
     * @JMS\Groups({"input"})
     */
    private ?string $date = null;

    /**
     * Identyfikator MPK (patrz opis metody adePfc_GetStatus)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("pfc")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private ?string $pfc = null;

    /**
     * Adres nadawcy (patrz opis metody adeSendAddr_GetStatus)
     * (Opcja)
     *
     * @JMS\Type("Webit\GlsAde\Model\SenderAddress")
     * @JMS\SerializedName("sendaddr")
     * @JMS\Groups({"input"})
     *
     */
    private ?SenderAddress $sendaddr = null;

    /**
     * Tablica z listą usług
     * (Opcja)
     *
     * @JMS\Type("Webit\GlsAde\Model\ServicesBool")
     * @JMS\SerializedName("srv_bool")
     * @JMS\Groups({"input"})
     *
     */
    private ?ServicesBool $srv_bool = null;

    /**
     * Usługi zapisane w standardzie ADE. Zawartość elementu użyta na wejściu jest ignorowana.
     * Przykład zawartości: COD 120.00PLN,EXW,ROD,POD,12:00.
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("srv_ade")
     * @JMS\Groups({"input"})
     *
     */
    private ?string $srv_ade = null;

    /**
     * Tablica z danymi usługi DAW
     * (Opcja)
     *
     *
     * @JMS\Type("Webit\GlsAde\Model\ServiceDaw")
     * @JMS\SerializedName("srv_daw")
     * @JMS\Groups({"input"})
     *
     */
    private ?ServiceDaw $srv_daw = null;

    /**
     * Tablica z danymi usługi IDENT
     * (Opcja)
     *
     *
     * @JMS\Type("Webit\GlsAde\Model\ServiceIdent")
     * @JMS\SerializedName("srv_ident")
     * @JMS\Groups({"input"})
     *
     */
    private ?ServiceIdent $srv_ident = null;

    /**
     * Tablica z danymi usług PR, PS, EXC i SRS
     * (Opcja)
     *
     * @JMS\Type("Webit\GlsAde\Model\ServicePpe")
     * @JMS\SerializedName("srv_ppe")
     * @JMS\Groups({"input"})
     *
     */
    private ?ServicePpe $srv_ppe = null;

    /**
     * Tablica z paczkami. W przypadku zastosowania struktury na wejściu, usługi podane
     * w poszczególnych paczkach są ignorowane i zastępowane przez usługi podane w elemencie srv_bool (nadrzędnym).
     * Opcja
     *
     *
     * @JMS\Type("ArrayCollection<Webit\GlsAde\Model\Parcel>")
     * @JMS\SerializedName("parcels")
     * @JMS\Groups({"input"})
     *
     */
    private ?ArrayCollection $parcels = null;

    /**
     * Flag, if consignment has been fetched from "Prepare" or "Pickup"
     * @var bool
     */
    private $dispatched = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRcity()
    {
        return $this->rcity;
    }

    /**
     * @param string $rcity
     */
    public function setRcity($rcity)
    {
        $this->rcity = $rcity;
    }

    /**
     * @return string
     */
    public function getRcontact()
    {
        return $this->rcontact;
    }

    /**
     * @param string $rcontact
     */
    public function setRcontact($rcontact)
    {
        $this->rcontact = $rcontact;
    }

    /**
     * @return string
     */
    public function getRcountry()
    {
        return $this->rcountry;
    }

    /**
     * @param string $rcountry
     */
    public function setRcountry($rcountry)
    {
        $this->rcountry = $rcountry;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getRname1()
    {
        return $this->rname1;
    }

    /**
     * @param string $rname1
     */
    public function setRname1($rname1)
    {
        $this->rname1 = $rname1;
    }

    /**
     * @return string
     */
    public function getRname2()
    {
        return $this->rname2;
    }

    /**
     * @param string $rname2
     */
    public function setRname2($rname2)
    {
        $this->rname2 = $rname2;
    }

    /**
     * @return string
     */
    public function getRname3()
    {
        return $this->rname3;
    }

    /**
     * @param string $rname3
     */
    public function setRname3($rname3)
    {
        $this->rname3 = $rname3;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return ArrayCollection
     */
    public function getParcels()
    {
        if ($this->parcels == null) {
            $this->parcels = new ArrayCollection();
        }

        return $this->parcels;
    }

    public function setParcels(ArrayCollection $parcels)
    {
        $this->parcels = $parcels;
    }

    /**
     * @param Parcel $parcel
     */
    public function addParcel(Parcel $parcel)
    {
        if (! $this->getParcels()->contains($parcel)) {
            $this->getParcels()->add($parcel);
        }
    }

    /**
     * @param Parcel $parcel
     */
    public function removeParcel(Parcel $parcel)
    {
        $this->getParcels()->removeElement($parcel);
    }

    /**
     * @return string
     */
    public function getPfc()
    {
        return $this->pfc;
    }

    /**
     * @param string $pfc
     */
    public function setPfc($pfc)
    {
        $this->pfc = $pfc;
    }

    /**
     * @return string
     */
    public function getRphone()
    {
        return $this->rphone;
    }

    /**
     * @param string $rphone
     */
    public function setRphone($rphone)
    {
        $this->rphone = $rphone;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param string $references
     */
    public function setReferences($references)
    {
        $this->references = $references;
    }

    /**
     * @return SenderAddress
     */
    public function getSendaddr()
    {
        return $this->sendaddr;
    }

    /**
     * @param SenderAddress $sendaddr
     */
    public function setSendaddr(SenderAddress $senderAddress = null)
    {
        $this->sendaddr = $senderAddress;
    }

    /**
     * @return ServiceDaw
     */
    public function getSrvDaw()
    {
        return $this->srv_daw;
    }

    /**
     * @param ServiceDaw $serviceDaw
     */
    public function setSrvAde(ServiceDaw $serviceDaw = null)
    {
        $this->srv_daw = $serviceDaw;
    }

    /**
     * @return ServiceIdent
     */
    public function getSrvIdent()
    {
        return $this->srv_ident;
    }

    /**
     * @param ServiceIdent $srv_ident
     */
    public function setSrvIdent(ServiceIdent $serviceIdent = null)
    {
        $this->srv_ident = $serviceIdent;
    }

    /**
     * @return ServicePpe
     */
    public function getSrvPpe()
    {
        return $this->srv_ppe;
    }

    /**
     * @param ServicePpe $srv_ppe
     */
    public function setSrvPpe(ServicePpe $servicePpe = null)
    {
        $this->srv_ppe = $servicePpe;
    }

    /**
     * @return string
     */
    public function getSrvAde()
    {
        return $this->srv_ade;
    }

    /**
     * @return ServicesBool
     */
    public function getSrvBool()
    {
        return $this->srv_bool;
    }

    /**
     * @param ServicesBool $servicesBool
     */
    public function setSrvBool(ServicesBool $servicesBool)
    {
        $this->srv_bool = $servicesBool;
    }

    /**
     * @return string
     */
    public function getRstreet()
    {
        return $this->rstreet;
    }

    /**
     * @param string $rstreet
     */
    public function setRstreet($rstreet)
    {
        $this->rstreet = $rstreet;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = (string)$weight;
    }

    /**
     * @return string
     */
    public function getRzipcode()
    {
        return $this->rzipcode;
    }

    /**
     * @param string $rzipcode
     */
    public function setRzipcode($rzipcode)
    {
        $this->rzipcode = $rzipcode;
    }

    /**
     * @return bool
     */
    public function isDispatched()
    {
        return $this->dispatched;
    }

    public function setDispatched($dispatched)
    {
        $this->dispatched = (bool) $dispatched;
    }
}
