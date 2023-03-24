<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class EventSearch
{
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (null === $this->getArtist() && null === $this->getCity() && null === $this->getDateStart() && null === $this->getDateEnd())
            $context->buildViolation('completer un champ au minimum')
                ->atPath('artist')
                ->addViolation();

        if ($this->getDateStart() && null === $this->getDateEnd()) {
            $context->buildViolation('La periode doit etre valide')
                ->atPath('dateEnd')
                ->addViolation();
        }

        if ($this->getDateEnd() && null === $this->getDateStart()) {
            $context->buildViolation('La periode doit etre valide')
                ->atPath('dateStart')
                ->addViolation();
        }
    }

    /**
     * @var String|null
     */
    private $artist;

    /**
     * @var City|null
     */
    private $city;

    /**
     * @var DateTime|null
     */
    private $dateStart;

    /**
     * @var DateTime|null
     */
    private $dateEnd;

    /**
     * Get the value of artist
     *
     * @return  String|null
     */
    public function getArtist(): ?String
    {
        return $this->artist;
    }

    /**
     * Set the value of artist
     *
     * @param  String|null  $artist
     *
     * @return  EventSearch
     */
    public function setArtist(?String $artist): EventSearch
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get the value of city
     *
     * @return  City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param  City|null  $city
     *
     * @return  EventSearch
     */
    public function setCity(?City $city): EventSearch
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of dateStart
     *
     * @return  DateTime|null
     */
    public function getDateStart(): ?DateTime
    {
        return $this->dateStart;
    }

    /**
     * Set the value of dateStart
     *
     * @param  DateTime|null  $dateStart
     *
     * @return  self
     */
    public function setDateStart(?DateTime $dateStart): EventSearch
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get the value of dateEnd
     *
     * @return  DateTime|null
     */
    public function getDateEnd(): ?DateTime
    {
        return $this->dateEnd;
    }

    /**
     * Set the value of dateEnd
     *
     * @param  EventSearch|null  $dateEnd
     *
     * @return  self
     */
    public function setDateEnd(?DateTime $dateEnd): EventSearch
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}
