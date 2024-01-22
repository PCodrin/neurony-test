import apiService from "./ApiService";

const candidateService = {
    contactCandidate(candidateId) {
        return apiService.post('/candidates/${candidateId}/contact');
    },
    hireCandidate(candidateId) {
        return apiService.post('/candidates/${candidateId}/hire');
    }
}

export default candidateService;