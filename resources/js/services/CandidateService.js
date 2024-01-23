import apiService from "./ApiService";

const candidateService = {
    contactCandidate(candidateId) {
        return apiService.post(`/candidates/${candidateId}/contact`, {'id': candidateId});
    },
    hireCandidate(candidateId) {
        return apiService.post(`/candidates/${candidateId}/hire`, {'id': candidateId});
    }
}

export default candidateService;