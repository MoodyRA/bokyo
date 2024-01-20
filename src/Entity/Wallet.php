<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'wallets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WalletType $type = null;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: WalletAsset::class, orphanRemoval: true)]
    private Collection $assets;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?WalletType
    {
        return $this->type;
    }

    public function setType(?WalletType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, WalletAsset>
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function addAsset(WalletAsset $asset): static
    {
        if (!$this->assets->contains($asset)) {
            $this->assets->add($asset);
            $asset->setWallet($this);
        }

        return $this;
    }

    public function removeAsset(WalletAsset $asset): static
    {
        if ($this->assets->removeElement($asset)) {
            // set the owning side to null (unless already changed)
            if ($asset->getWallet() === $this) {
                $asset->setWallet(null);
            }
        }

        return $this;
    }
}
