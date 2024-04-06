                                        <td>
                                              <div class="dropdown">
                                                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                      <a class="dropdown-item view-report" href="#" onclick="trackButtonClick('View')">
                                                          <i class="bi bi-eye-fill"></i> View
                                                      </a>
                                                      <a class="dropdown-item" href="photos.php?groupId=<?php echo $projectId ?>&weekId=<?php echo $agendaId ?>" onclick="trackButtonClick('Photos')">
                                                      <i class="bi bi-image-fill"></i> Photos
                                                  </a>

                                                      <!-- <a class="dropdown-item" href="#" onclick="trackButtonClick('Feedback daily')">
                                                          <i class="bi bi-chat-left-dots-fill"></i> Feedback
                                                      </a> -->
                                                  </div>
                                              </div>
                                          </td>