<?php 

namespace NamespacesName\Auth\Hashing;

interface Hasher
{
    // Taking plain password and create hashing.
    public function create($plain);
    
    // Check if plain and hash match.
    public function check($plain, $hash);
    
    // In case we need to re-hash.
    public function needsRehash($hash);
}