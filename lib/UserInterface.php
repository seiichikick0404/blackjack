<?php

namespace BlackJack\lib;

interface UserInterface
{
    /**
     * firstDrawCards
     * @param UserInterface $user
     * @return array<int>
     */
    public function firstDrawCards(UserInterface $user): array;

    /**
     * drawCards
     * @param UserInterface $user
     * @return array<int>
     */
    public function drawCards(UserInterface $user): array;
    public function getScore(): int;
}
