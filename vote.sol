// SPDX-License-Identifier: GPL-3.0
pragma solidity ^0.8.0;

contract Voting {
    struct Candidate {
        uint256 id;
        string name;
        string program;
        string faculty;
        uint256 voteCount;
    }

    mapping(uint256 => Candidate) public candidates;
    mapping(address => bool) public voters;

    uint256 public candidatesCount;

    event Voted(uint256 indexed candidateId);

    constructor() {
        addCandidate("Afiqah Mohsin", "Bachelor of Biology", "Faculty of Science");
        addCandidate("Edward Lim", "Bachelor of Data Engineering", "Faculty of Computing");
    }

    function addCandidate(string memory _name, string memory _program, string memory _faculty) private {
        candidatesCount++;
        candidates[candidatesCount] = Candidate(candidatesCount, _name, _program, _faculty, 0);
    }

    function vote(uint256 _candidateId) public {
        require(!voters[msg.sender], "You have already voted.");
        require(_candidateId > 0 && _candidateId <= candidatesCount, "Invalid candidate ID.");

        candidates[_candidateId].voteCount++;
        voters[msg.sender] = true;

        emit Voted(_candidateId);
    }

    function getCandidateVoteCount(uint256 _candidateId) public view returns (uint256) {
        require(_candidateId > 0 && _candidateId <= candidatesCount, "Invalid candidate ID.");

        return candidates[_candidateId].voteCount;
    }
}
