<?php
/**
 * Created by PhpStorm.
 * User: leoflapper
 * Date: 04/05/2018
 * Time: 11:25
 */

namespace Wefabric\Countries;


use Wefabric\Countries\Exceptions\AddressInvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Address implements Arrayable, Jsonable
{

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $salutation = '';

    /**
     * @var string
     */
    protected $firstname = '';

    /**
     * @var string
     */
    protected $lastname = '';

    /**
     * @var string
     */
    protected $street = '';

    /**
     * @var string
     */
    protected $housenumber = '';

    /**
     * @var string
     */
    protected $housenumberAddition = '';

    /**
     * @var string
     */
    protected $city = '';

    /**
     * @var string
     */
    protected $postcode = '';

    /**
     * @var string
     */
    protected $countryId = '';

    /**
     * @var
     */
    protected $email = '';

    /**
     * @var
     */
    protected $telephone = '';

    /**
     * @var string
     */
    protected $vatId = '';

    /**
     * @var string
     */
    protected $companyRegistrationNumber = '';

    /**
     * @var string
     */
    protected $latitude = '';

    /**
     * @var string
     */
    protected $longitude = '';

    /**
     * @var AddressMeta
     */
    protected $meta;

    /**
     * @var array
     */
    protected $labels = [];


    /**
     * @var array
     */
    protected $originalValues = [];

    /**
     * @var array
     */
    protected $modified = [];

    /**
     * Address constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if($data) {
            $this->fromArray($data);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'company' => $this->getCompany(),
            'salutation' => $this->getSalutation(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'street' => $this->getStreet(),
            'housenumber' => $this->getHousenumber(),
            'housenumberAddition' => $this->getHousenumberAddition(),
            'city' => $this->getCity(),
            'postcode' => $this->getPostcode(),
            'countryId' => $this->getCountryId(),
            'email' => $this->getEmail(),
            'telephone' => $this->getTelephone(),
            'vatId' => $this->getVatId(),
            'companyRegistrationNumber' => $this->getCompanyRegistrationNumber(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'meta' => $this->getMeta()->toArray()
        ];
    }

    /**
     * @param $data
     */
    public function fromArray($data)
    {
        if(isset($data['company'])) {
            $this->setCompany($data['company']);
        }

        if(isset($data['salutation'])) {
            $this->setSalutation($data['salutation']);
        }

        if(isset($data['firstname'])) {
            $this->setFirstname($data['firstname']);
        }

        if(isset($data['lastname'])) {
            $this->setLastname($data['lastname']);
        }

        if(isset($data['street'])) {
            $this->setStreet($data['street']);
        }

        if(isset($data['housenumber'])) {
            $this->setHousenumber($data['housenumber']);
        }

        if(isset($data['housenumberAddition'])) {
            $this->setHousenumberAddition($data['housenumberAddition']);
        }

        if(isset($data['city'])) {
            $this->setCity($data['city']);
        }

        if(isset($data['postcode'])) {
            $this->setPostcode($data['postcode']);
        }

        if(isset($data['countryId'])) {
            $this->setCountryId($data['countryId']);
        }

        if(isset($data['email'])) {
            $this->setEmail($data['email']);
        }

        if(isset($data['telephone'])) {
            $this->setTelephone($data['telephone']);
        }

        if(isset($data['vatId'])) {
            $this->setVatId($data['vatId']);
        }

        if(isset($data['companyRegistrationNumber'])) {
            $this->setCompanyRegistrationNumber($data['companyRegistrationNumber']);
        }

        if(isset($data['latitude'])) {
            $this->setLatitude($data['latitude']);
        }

        if(isset($data['longitude'])) {
            $this->setLongitude($data['longitude']);
        }

        if(isset($data['meta'])) {
            $this->setMeta($data['meta']);
        }
    }

    /**
     * @return false|string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @param $key
     * @return string
     */
    public function getLabel($key): string
    {
        $labels = $this->getLabels();
        if(!isset($labels[$key])) {
            return '';
        }
        return $labels[$key];
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        if(!$this->labels) {
            $this->setLabels();
        }
        return $this->labels;
    }

    private function setLabels(): void
    {
        $this->labels = [
            'company'                       => $this->translate('company'),
            'salutation'                    => $this->translate('salutation'),
            'firstname'                     => $this->translate('firstname'),
            'lastname'                      => $this->translate('lastname'),
            'street'                        => $this->translate('street'),
            'housenumber'                   => $this->translate('housenumber'),
            'housenumberAddition'           => $this->translate('housenumberAddition'),
            'city'                          => $this->translate('city'),
            'postcode'                      => $this->translate('postcode'),
            'country'                       => $this->translate('country'),
            'email'                         => $this->translate('email'),
            'telephone'                     => $this->translate('telephone'),
            'vatId'                         => $this->translate('vatId'),
            'companyRegistrationNumber'     => $this->translate('company registration number'),
            'latitude'                      => $this->translate('latitude'),
            'longitude'                     => $this->translate('longitude')
        ];
    }

    private function translate($key)
    {
        return trans('countries::address.'.$key);
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company)
    {
        $this->set('company', $company);
    }

    /**
     * @return string
     */
    public function getSalutation(): string
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation(string $salutation)
    {
        $this->set('salutation', $salutation);
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname)
    {
        $this->set('firstname', $firstname);
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->set('lastname', $lastname);
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street)
    {
        $this->set('street', $street);
    }

    /**
     * @return string
     */
    public function getHousenumber(): string
    {
        return $this->housenumber;
    }

    /**
     * @param string $housenumber
     */
    public function setHousenumber(string $housenumber)
    {
        $this->set('housenumber', $housenumber);
    }

    /**
     * @return string
     */
    public function getHousenumberAddition(): string
    {
        return $this->housenumberAddition;
    }

    /**
     * @param string $housenumberAddition
     */
    public function setHousenumberAddition(string $housenumberAddition): void
    {
        $this->set('housenumberAddition', $housenumberAddition);
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->set('city', $city);
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode)
    {
        $this->set('postcode', $postcode);
    }

    /**
     * @return null
     */
    public function getCountry()
    {
        return \Countries::collection()->get($this->getCountryId());
    }

    /**
     * @return string
     */
    public function getCountryId(): string
    {
        if(!$this->countryId) {
            $this->set('countryId', \Countries::collection()->first()->getIso());
        }
        return $this->countryId;
    }

    /**
     * @param string $countryId
     */
    public function setCountryId(string $countryId)
    {
        $this->set('countryId', $countryId);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->set('email', $email);
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->set('telephone', $telephone);
    }

    /**
     * @return string
     */
    public function getVatId(): string
    {
        return $this->vatId;
    }

    /**
     * @param string $vatId
     */
    public function setVatId(string $vatId)
    {
        $vatId = str_replace('.', '', $vatId);
        $vatId = str_replace(' ', '', $vatId);

        $countryCode = substr($vatId, 0, 2);

        if(is_numeric($countryCode)) {
            $vatId = $this->getCountryId().$vatId;
        }

        $this->set('vatId', $vatId);
    }

    /**
     * @return string
     */
    public function getCompanyRegistrationNumber(): string
    {
        return $this->companyRegistrationNumber;
    }

    /**
     * @param string $companyRegistrationNumber
     */
    public function setCompanyRegistrationNumber(string $companyRegistrationNumber)
    {
        $this->set('companyRegistrationNumber', $companyRegistrationNumber);
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude)
    {
        $this->set('latitude', $latitude);
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude)
    {
        $this->set('longitude', $longitude);
    }

    /**
     * @return AddressMeta
     */
    public function getMeta(): AddressMeta
    {
        if(!$this->meta) {
            $this->meta = new AddressMeta();
        }

        return $this->meta;
    }

    /**
     * @param $property
     * @param $value
     */
    public function set($property, $value)
    {
        if(!isset($this->$property)) {
            throw new \InvalidArgumentException(sprintf('Property "%s" does not exist on address', $property));
        }

        if($this->$property !== $value || '' === $this->$property) {

            if(!isset($this->originalValues[$property])) {
                if($this->$property === '') {
                    $this->originalValues[$property] = $value;
                } else {
                    $this->originalValues[$property] = $this->$property;
                }

            }

            $this->$property = $value;


            if($this->originalValues[$property] !== $value) {
                $this->setModified($property, $value);
            }
        }
    }

    /**
     * @return array
     */
    public function getOriginalValues(): array
    {
        return $this->originalValues;
    }

    /**
     * @return array
     */
    public function getModified(): array
    {
        return $this->modified;
    }

    /**
     * @param string $key
     */
    private function setModified(string $key, $value): void
    {
        $this->modified[$key] = $value;
    }

    /**
     * @param string $key
     */
    private function removeModified(string $key): void
    {
        if(isset($this->modified[$key])) {
            unset($this->modified[$key]);
        }

    }

    /**
     * @param AddressMeta $meta
     */
    public function setMeta( $meta)
    {
        if(!$meta instanceof AddressMeta) {
            if(is_array($meta)) {
                $meta = new AddressMeta($meta);
            } else {
                throw new AddressInvalidArgumentException(sprintf(
                    '%s: expects a array or AddressMeta argument; received "%s"',
                    __METHOD__,
                    (is_object($meta) ? get_class($meta) : gettype($meta))
                ));
            }
        }

        $this->meta = $meta;
    }

    public function addMeta($key, $value)
    {
        if(!$this->meta) {
            $this->meta = new AddressMeta();
        }

        $this->meta->put($key, $value);
    }


}
